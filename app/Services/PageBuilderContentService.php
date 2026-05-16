<?php

namespace App\Services;

use App\Models\PageAsset;
use App\Models\PageBlock;
use App\Models\PageContent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PageBuilderContentService
{
    private const VERSION_KEY_PREFIX = 'page_builder:version:';
    private const PAYLOAD_KEY_PREFIX = 'page_builder:payload:';

    public function getPagePayload(string $pageKey): array
    {
        $default = $this->defaultPayload($pageKey);

        if (! $this->tablesReady()) {
            return $default;
        }

        $version = $this->currentVersion($pageKey);
        $payloadKey = self::PAYLOAD_KEY_PREFIX.$pageKey.':v'.$version;

        $payload = Cache::rememberForever($payloadKey, function () use ($pageKey, $default) {
            $pageContent = PageContent::query()->where('page_key', $pageKey)->first();

            if (! $pageContent) {
                return $default;
            }

            $meta = $pageContent->meta ?? [];

            $blocks = PageBlock::query()
                ->with('asset')
                ->forPage($pageKey)
                ->active()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            $resolvedBlocks = $blocks->map(fn (PageBlock $block) => $this->resolveBlock($block))
                ->filter()
                ->values()
                ->all();

            if (! $pageContent->is_initialized && count($resolvedBlocks) === 0) {
                return [
                    'title' => $pageContent->title ?: $default['title'],
                    'badge_text' => trim((string) ($meta['hero_badge_text'] ?? $meta['badge_text'] ?? '')) ?: $default['badge_text'],
                    'meta' => array_merge($default['meta'] ?? [], $meta),
                    'blocks' => $default['blocks'],
                    'updated_at' => $pageContent->updated_at?->toIso8601String(),
                ];
            }

            return [
                'title' => $pageContent->title ?: $default['title'],
                'badge_text' => trim((string) ($meta['hero_badge_text'] ?? $meta['badge_text'] ?? '')) ?: $default['badge_text'],
                'meta' => array_merge($default['meta'] ?? [], $meta),
                'blocks' => $resolvedBlocks,
                'updated_at' => $pageContent->updated_at?->toIso8601String(),
            ];
        });

        return array_merge($default, $payload, [
            'meta' => array_merge($default['meta'] ?? [], $payload['meta'] ?? []),
        ]);
    }

    public function currentVersion(string $pageKey): int
    {
        $versionKey = self::VERSION_KEY_PREFIX.$pageKey;

        return (int) Cache::rememberForever($versionKey, function () use ($pageKey) {
            if (! Schema::hasTable('page_contents')) {
                return 1;
            }

            $version = PageContent::query()->where('page_key', $pageKey)->value('cache_version');

            return max(1, (int) ($version ?? 1));
        });
    }

    public function bumpVersion(PageContent $pageContent): int
    {
        $oldVersion = max(1, (int) $pageContent->cache_version);
        $pageContent->increment('cache_version');
        $pageContent->refresh();

        $newVersion = max(1, (int) $pageContent->cache_version);
        Cache::forever(self::VERSION_KEY_PREFIX.$pageContent->page_key, $newVersion);
        Cache::forget(self::PAYLOAD_KEY_PREFIX.$pageContent->page_key.':v'.$oldVersion);

        return $newVersion;
    }

    public function formatBytes(?int $bytes): string
    {
        $value = max(0, (int) $bytes);

        if ($value >= 1024 * 1024) {
            return number_format($value / (1024 * 1024), 1).' MB';
        }

        if ($value >= 1024) {
            return number_format($value / 1024, 0).' KB';
        }

        return $value.' B';
    }

    public function tablesReady(): bool
    {
        return Schema::hasTable('page_contents')
            && Schema::hasTable('page_blocks')
            && Schema::hasTable('page_assets');
    }

    private function resolveBlock(PageBlock $block): ?array
    {
        $payload = $block->payload ?? [];

        return match ($block->block_type) {
            'text' => [
                'id' => $block->id,
                'type' => 'text',
                'heading' => trim((string) ($payload['heading'] ?? '')),
                'body' => trim((string) ($payload['body'] ?? '')),
                'paragraphs' => $this->paragraphs((string) ($payload['body'] ?? '')),
                'segments' => $this->segments((string) ($payload['body'] ?? '')),
            ],
            'image' => $block->asset ? [
                'id' => $block->id,
                'type' => 'image',
                'caption' => trim((string) ($payload['caption'] ?? '')),
                'alt_text' => trim((string) ($payload['alt_text'] ?? '')) ?: trim((string) ($block->asset->original_name ?: 'Gambar PPDB')),
                'asset' => $this->resolveAsset($block->asset),
            ] : null,
            'file' => $block->asset ? [
                'id' => $block->id,
                'type' => 'file',
                'label' => trim((string) ($payload['label'] ?? '')),
                'description' => trim((string) ($payload['description'] ?? '')),
                'button_text' => trim((string) ($payload['button_text'] ?? 'Unduh File')),
                'asset' => $this->resolveAsset($block->asset),
            ] : null,
            'link' => [
                'id' => $block->id,
                'type' => 'link',
                'label' => trim((string) ($payload['label'] ?? '')),
                'url' => trim((string) ($payload['url'] ?? '')),
                'description' => trim((string) ($payload['description'] ?? '')),
                'style_variant' => trim((string) ($payload['style_variant'] ?? 'brand')) ?: 'brand',
            ],
            default => null,
        };
    }

    private function resolveAsset(PageAsset $asset): array
    {
        $disk = $asset->disk ?: 'public';

        return [
            'id' => $asset->id,
            'asset_type' => $asset->asset_type,
            'name' => $asset->original_name,
            'mime_type' => $asset->mime_type,
            'size_bytes' => (int) ($asset->size_bytes ?? 0),
            'size_label' => $this->formatBytes((int) ($asset->size_bytes ?? 0)),
            'original_url' => $this->toPublicUrl($disk, $asset->original_path),
            'jpeg_url' => $this->toPublicUrl($disk, $asset->jpeg_path),
            'webp_url' => $this->toPublicUrl($disk, $asset->webp_path),
            'width' => $asset->width,
            'height' => $asset->height,
            'extension' => strtolower(pathinfo($asset->original_name, PATHINFO_EXTENSION)),
        ];
    }

    private function toPublicUrl(string $disk, ?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Storage::disk($disk)->url(ltrim($path, '/'));
    }

    /**
     * @return array<int, string>
     */
    private function paragraphs(string $body): array
    {
        return collect(preg_split('/\R{2,}/', trim($body)) ?: [])
            ->map(fn (string $paragraph) => trim($paragraph))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function segments(string $body): array
    {
        return collect($this->paragraphs($body))
            ->map(function (string $paragraph) {
                $lines = collect(preg_split('/\R/', $paragraph) ?: [])
                    ->map(fn (string $line) => trim($line))
                    ->filter()
                    ->values();

                if ($lines->isNotEmpty() && $lines->every(fn (string $line) => str_starts_with($line, '- '))) {
                    return [
                        'type' => 'list',
                        'items' => $lines->map(fn (string $line) => trim(substr($line, 2)))->values()->all(),
                    ];
                }

                return [
                    'type' => 'paragraph',
                    'content' => $paragraph,
                ];
            })
            ->values()
            ->all();
    }

    private function defaultPayload(string $pageKey): array
    {
        if ($pageKey === 'profil') {
            return [
                'title' => 'Tentang Kami - SMKN 1 Wringin',
                'badge_text' => '22 Tahun Mengabdi',
                'meta' => [
                    'hero_badge_text' => '22 Tahun Mengabdi',
                    'hero_title' => 'Mengenal Lebih Dekat SMKN 1 Wringin',
                    'hero_description' => 'Menjadi SMK Pusat Keunggulan yang mencetak generasi Creativepreneur berkarakter, siap bersaing di dunia industri dan usaha.',
                    'sejarah_title' => 'Sejarah Berdirinya SmakinOne',
                    'sejarah_body' => "SMK Negeri 1 Wringin berdiri pada 01 September 2004 berdasarkan SK Ijin Pendirian dan Operasional Nomor: 4215/2074.a/430.520/2004. Kehadirannya berangkat dari upaya meningkatkan angka partisipasi sekolah tamatan SMP yang cukup rendah, melalui program SMK Kecil di SMP di bawah naungan Pemerintah Kabupaten Bondowoso. Program ini menjadi strategi pemerataan akses pendidikan, sehingga hampir setiap kecamatan memiliki SMK dengan karakteristik keahlian sesuai potensi wilayah.\n\nPada awalnya, SMKN 1 Wringin menjalankan kegiatan pembelajaran bersama SMPN 1 Wringin dengan berbagi lahan, membuka dua konsentrasi keahlian: Teknik Audio Video dan Teknik Bangunan. Seiring meningkatnya minat dan kebutuhan masyarakat, sekolah terus beradaptasi dengan membuka Teknik Komputer dan Jaringan pada tahun 2006, serta Desain Komunikasi Visual pada tahun 2011.\n\nDan sejak tahun 2015, pengelolaan pendidikan menengah berada di bawah Dinas Pendidikan Provinsi Jawa Timur, namun komitmen untuk mencetak putra-putri daerah tetap menjadi ruh utama. Kini, SMKN 1 Wringin atau SmakinOne berkembang dengan empat konsentrasi keahlian: TAV, TKJ, DKV, dan Teknik Kendaraan Ringan Otomotif (TKRO). SmakinOne semakin dikenal sebagai SMK Pusat Keunggulan bidang Ekonomi Kreatif yang sukses mengembangkan pembelajaran Teaching Factory sebagai jembatan menuju dunia usaha dan industri.",
                    'keunggulan_intro' => 'Lingkungan belajar yang holistik untuk mencetak talenta-talenta siap kerja dan siap berkarya.',
                    'keunggulan_items' => "Lingkungan belajar yang representatif dan kondusif\nFasilitas serta sarana-prasarana pembelajaran berorientasi lingkungan serta berbasis teknologi\nProgram Link and Match\nPengelolaan kegiatan pembelajaran yang kontekstual melalui kemitraan dengan industri dan masyarakat\nTenaga Guru dan Kependidikan yang Profesional\nGTK dengan sertifikasi pendidik dan pengalaman industri\nPengembangan Potensi\nProgram pengembangan bakat dan",
                    'visi_title' => 'Terwujudnya Lulusan SMAKIN KEREN',
                    'visi_body' => 'Lulusan SMKN 1 Wringin sebagai Creativepreneur Berkarakter',
                    'misi_items' => "Membina keimanan dan ketaqwaan kepada Tuhan Yang Maha Esa serta akhlak mulia\nMenyelenggarakan pendidikan vokasi untuk mencapai 8 dimensi profil lulusan\nMeningkatkan profesionalisme Guru dan Tenaga Kependidikan\nMeningkatkan mutu layanan pendidikan melalui pemenuhan sarana-prasarana berbasis teknologi\nMeningkatkan kerjasama dan kolaborasi dengan seluruh pemangku kepentingan",
                    'motto_text' => 'Creativepreneurs Start Here',
                    'cta_title' => 'Bergabunglah Bersama Keluarga Besar Kami',
                    'cta_description' => 'Jadilah bagian dari generasi penerus yang inovatif, berkarakter, dan siap menghadapi tantangan masa depan bersama SMKN 1 Wringin.',
                ],
                'blocks' => [],
                'updated_at' => null,
            ];
        }

        if ($pageKey !== 'ppdb') {
            return ['title' => 'Halaman', 'badge_text' => '', 'meta' => [], 'blocks' => [], 'updated_at' => null];
        }

        return [
            'title' => 'Informasi Lengkap Pendaftaran Jalur Prestasi & Reguler',
            'badge_text' => 'Informasi Resmi PPDB',
            'meta' => [],
            'updated_at' => null,
            'blocks' => [
                [
                    'id' => null,
                    'type' => 'text',
                    'heading' => '',
                    'body' => 'Selamat datang calon siswa-siswi SMKN 1 Wringin! Kami membuka kesempatan bagi talenta-talenta muda untuk bergabung dan berkembang bersama dalam ekosistem pendidikan vokasi berbasis Budaya Positif.\n\nPenerimaan Peserta Didik Baru (PPDB) tahun ini dilakukan secara terpusat melalui portal online untuk menjamin transparansi dan kemudahan akses bagi seluruh pendaftar dari berbagai daerah.',
                    'paragraphs' => [
                        'Selamat datang calon siswa-siswi SMKN 1 Wringin! Kami membuka kesempatan bagi talenta-talenta muda untuk bergabung dan berkembang bersama dalam ekosistem pendidikan vokasi berbasis Budaya Positif.',
                        'Penerimaan Peserta Didik Baru (PPDB) tahun ini dilakukan secara terpusat melalui portal online untuk menjamin transparansi dan kemudahan akses bagi seluruh pendaftar dari berbagai daerah.',
                    ],
                    'segments' => [
                        ['type' => 'paragraph', 'content' => 'Selamat datang calon siswa-siswi SMKN 1 Wringin! Kami membuka kesempatan bagi talenta-talenta muda untuk bergabung dan berkembang bersama dalam ekosistem pendidikan vokasi berbasis Budaya Positif.'],
                        ['type' => 'paragraph', 'content' => 'Penerimaan Peserta Didik Baru (PPDB) tahun ini dilakukan secara terpusat melalui portal online untuk menjamin transparansi dan kemudahan akses bagi seluruh pendaftar dari berbagai daerah.'],
                    ],
                ],
                [
                    'id' => null,
                    'type' => 'text',
                    'heading' => 'Persyaratan Umum Pendaftaran',
                    'body' => 'Sebelum memulai proses pendaftaran, pastikan Anda telah menyiapkan dokumen digital (scan) berikut ini. Ukuran maksimal setiap file adalah 2MB dalam format PDF atau JPG.\n\n- Scan Kartu Keluarga (KK) asli.\n- Scan Surat Keterangan Lulus (SKL) atau Ijazah SMP/sederajat.\n- Scan Akta Kelahiran.\n- Pas foto terbaru (latar merah) ukuran 3x4.\n- Sertifikat prestasi akademik/non-akademik minimal tingkat Kabupaten/Kota (Khusus Jalur Prestasi).',
                    'paragraphs' => [
                        'Sebelum memulai proses pendaftaran, pastikan Anda telah menyiapkan dokumen digital (scan) berikut ini. Ukuran maksimal setiap file adalah 2MB dalam format PDF atau JPG.',
                        '- Scan Kartu Keluarga (KK) asli.\n- Scan Surat Keterangan Lulus (SKL) atau Ijazah SMP/sederajat.\n- Scan Akta Kelahiran.\n- Pas foto terbaru (latar merah) ukuran 3x4.\n- Sertifikat prestasi akademik/non-akademik minimal tingkat Kabupaten/Kota (Khusus Jalur Prestasi).',
                    ],
                    'segments' => [
                        ['type' => 'paragraph', 'content' => 'Sebelum memulai proses pendaftaran, pastikan Anda telah menyiapkan dokumen digital (scan) berikut ini. Ukuran maksimal setiap file adalah 2MB dalam format PDF atau JPG.'],
                        ['type' => 'list', 'items' => ['Scan Kartu Keluarga (KK) asli.', 'Scan Surat Keterangan Lulus (SKL) atau Ijazah SMP/sederajat.', 'Scan Akta Kelahiran.', 'Pas foto terbaru (latar merah) ukuran 3x4.', 'Sertifikat prestasi akademik/non-akademik minimal tingkat Kabupaten/Kota (Khusus Jalur Prestasi).']],
                    ],
                ],
                [
                    'id' => null,
                    'type' => 'link',
                    'label' => 'Formulir Jalur Prestasi (Akademik & Non-Akademik)',
                    'url' => '#',
                    'description' => 'Tautan pendaftaran untuk jalur prestasi.',
                    'style_variant' => 'brand',
                ],
                [
                    'id' => null,
                    'type' => 'link',
                    'label' => 'Formulir Jalur Reguler (Tes Tulis)',
                    'url' => '#',
                    'description' => 'Tautan pendaftaran untuk jalur reguler.',
                    'style_variant' => 'outline',
                ],
            ],
        ];
    }
}
