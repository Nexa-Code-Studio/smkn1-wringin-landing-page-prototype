<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use App\Models\NewsArticleBlock;
use App\Models\NewsArticleBlockMedia;
use App\Models\NewsArticleTag;
use App\Models\NewsFeaturedArticle;
use App\Models\PageAsset;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::query()->value('id');

        $publishedArticles = [
            [
                'category' => 'Inovasi & Teknologi',
                'title' => 'Eksplorasi Inovasi Teknologi Energi Terbarukan oleh Siswa Teknik',
                'slug' => 'inovasi-teknologi-energi-terbarukan',
                'excerpt' => 'Siswa SMKN 1 Wringin mengembangkan sistem pemantauan energi surya berbasis IoT untuk meningkatkan efisiensi panel surya sekolah.',
                'author_name' => 'Tim Humas SMKN 1 Wringin',
                'cover' => 'images/berita-prestasi.jpg',
                'published_at' => '2023-12-11 09:00:00',
                'tags' => ['#Teknologi', '#EnergiTerbarukan', '#InovasiSiswa'],
                'blocks' => [
                    ['type' => 'text', 'payload' => ['heading' => '', 'body' => "Bondowoso - SMKN 1 Wringin kembali menunjukkan tajinya di bidang teknologi hijau. Kali ini, siswa dari kompetensi keahlian Teknik Audio Video berhasil mengembangkan prototipe sistem pemantauan energi terbarukan berbasis Internet of Things.\n\nProyek ini dirancang untuk memaksimalkan efisiensi penyerapan energi matahari pada panel surya yang terpasang di lingkungan sekolah."]],
                    ['type' => 'highlight_text', 'payload' => ['text' => 'Kami ingin membuktikan bahwa teknologi ramah lingkungan bisa dipelajari dan dikembangkan sejak tingkat sekolah menengah kejuruan.']],
                    ['type' => 'image_showcase', 'payload' => ['alt_text' => 'Rangkaian kontrol IoT'], 'media' => ['images/berita-kunjungan.jpg', 'images/berita-prestasi.jpg', 'images/foto-sekolah.jpg']],
                ],
            ],
            [
                'category' => 'Startup & RPL',
                'title' => 'Dari Ide Menjadi Dampak: Perjalanan Startup Digital Siswa RPL',
                'slug' => 'startup-digital-rpl',
                'excerpt' => 'Tim siswa RPL membangun produk digital sederhana untuk kebutuhan UMKM lokal dan mempresentasikannya dalam forum sekolah.',
                'author_name' => 'Tim Produktif RPL',
                'cover' => 'images/berita-kunjungan.jpg',
                'published_at' => '2023-12-08 10:30:00',
                'tags' => ['#StartupRPL', '#ProdukDigital', '#KaryaSiswa'],
                'blocks' => [
                    ['type' => 'text', 'payload' => ['heading' => 'Belajar dari masalah nyata', 'body' => "Pembelajaran berbasis proyek di jurusan RPL mendorong siswa untuk menyusun solusi digital yang benar-benar dibutuhkan pengguna.\n\nSalah satu tim mengembangkan aplikasi katalog sederhana untuk membantu promosi UMKM sekitar sekolah."]],
                ],
            ],
            [
                'category' => 'Industri & TKJ',
                'title' => 'Navigasi Lanskap Teknologi Melalui Kunjungan Industri TKJ',
                'slug' => 'strategi-sukses-teknologi',
                'excerpt' => 'Siswa TKJ mendapat gambaran langsung tentang manajemen jaringan, server, dan ritme kerja profesional melalui kunjungan industri.',
                'author_name' => 'Humas TKJ',
                'cover' => 'images/foto-sekolah.jpg',
                'published_at' => '2023-12-08 08:00:00',
                'tags' => ['#TKJ', '#KunjunganIndustri', '#Jaringan'],
                'blocks' => [
                    ['type' => 'text', 'payload' => ['heading' => '', 'body' => "Melalui kunjungan industri, siswa TKJ diajak memahami standar kerja profesional mulai dari dokumentasi, pengamanan jaringan, hingga pemeliharaan server.\n\nKegiatan ini menjadi jembatan antara pembelajaran laboratorium dengan kebutuhan industri yang nyata."]],
                    ['type' => 'image_showcase', 'payload' => ['alt_text' => 'Kunjungan industri TKJ'], 'media' => ['images/berita-kunjungan.jpg', 'images/profil-praktek.jpg']],
                ],
            ],
            [
                'category' => 'Otomotif',
                'title' => 'Di Balik Layar Praktik Kerja Lapangan Jurusan Otomotif',
                'slug' => 'pameran-produk-inovatif',
                'excerpt' => 'Pengalaman PKL mempertemukan siswa otomotif dengan SOP bengkel modern, budaya kerja disiplin, dan standar servis industri.',
                'author_name' => 'Tim BKK',
                'cover' => 'images/profil-praktek.jpg',
                'published_at' => '2023-12-07 13:00:00',
                'tags' => ['#PKL', '#Otomotif', '#SiapKerja'],
                'blocks' => [
                    ['type' => 'text', 'payload' => ['heading' => 'Adaptasi ke dunia kerja', 'body' => "Praktik Kerja Lapangan membantu siswa memahami alur kerja bengkel modern dengan tempo yang lebih dinamis dan terukur.\n\nSelain kompetensi teknis, siswa juga dilatih disiplin, komunikasi, dan tanggung jawab terhadap pelanggan."]],
                    ['type' => 'highlight_text', 'payload' => ['text' => 'PKL bukan hanya tempat belajar servis kendaraan, tetapi juga tempat membangun mental kerja profesional.']],
                ],
            ],
            [
                'category' => 'Inovasi Siswa',
                'title' => 'Merintis Masa Depan Melalui Pameran Produk Inovatif',
                'slug' => 'ai-manufaktur-modern',
                'excerpt' => 'Pameran produk siswa menjadi ruang unjuk karya, validasi ide, dan latihan presentasi untuk calon creativepreneur muda sekolah.',
                'author_name' => 'Panitia Pameran Sekolah',
                'cover' => 'images/berita-pensi.jpg',
                'published_at' => '2023-12-06 11:00:00',
                'tags' => ['#PameranProduk', '#Creativepreneur', '#InovasiSiswa'],
                'blocks' => [
                    ['type' => 'text', 'payload' => ['heading' => '', 'body' => "Pameran produk inovatif mempertemukan karya siswa dari berbagai jurusan dalam satu ruang kolaborasi.\n\nSelain memamerkan hasil belajar, kegiatan ini menjadi simulasi nyata menghadapi audiens dan calon mitra."]],
                ],
            ],
            [
                'category' => 'Tips Belajar',
                'title' => 'Kebiasaan Hidup Sehat untuk Gaya Belajar yang Sibuk',
                'slug' => 'hidup-sehat-gaya-belajar',
                'excerpt' => 'Rutinitas sederhana seperti tidur teratur, hidrasi, dan jeda belajar yang sehat membantu siswa tetap produktif sepanjang minggu.',
                'author_name' => 'BK SMKN 1 Wringin',
                'cover' => 'images/alternative/default_picture.jpeg',
                'published_at' => '2023-12-05 07:30:00',
                'tags' => ['#TipsBelajar', '#HidupSehat', '#Produktif'],
                'blocks' => [
                    ['type' => 'text', 'payload' => ['heading' => 'Ritme sehat itu realistis', 'body' => "Belajar padat tidak harus identik dengan pola hidup berantakan. Siswa tetap bisa menjaga energi dengan rutinitas kecil yang konsisten.\n\n- Tidur cukup sebelum hari praktik.\n- Membawa botol minum sendiri.\n- Menyusun jeda belajar singkat di antara tugas.\n- Mengurangi kebiasaan menunda pekerjaan."]],
                ],
            ],
        ];

        DB::transaction(function () use ($publishedArticles, $adminId) {
            $publishedIds = [];

            foreach ($publishedArticles as $articleData) {
                $coverAsset = $this->imageAsset($articleData['slug'].'-cover.jpg', $articleData['cover'], $adminId);

                $article = NewsArticle::query()->updateOrCreate(
                    ['slug' => $articleData['slug']],
                    [
                        'category_id' => null,
                        'category_name' => $articleData['category'],
                        'title' => $articleData['title'],
                        'excerpt' => $articleData['excerpt'],
                        'author_name' => $articleData['author_name'],
                        'cover_asset_id' => $coverAsset->id,
                        'cover_alt_text' => $articleData['title'],
                        'workflow_status' => 'published',
                        'source_type' => 'admin',
                        'submitted_by_type' => User::class,
                        'submitted_by_id' => $adminId,
                        'published_at' => Carbon::parse($articleData['published_at']),
                        'created_by' => $adminId,
                        'updated_by' => $adminId,
                    ]
                );

                $publishedIds[] = $article->id;

                NewsArticleTag::query()->where('news_article_id', $article->id)->delete();
                foreach (array_values($articleData['tags']) as $index => $tag) {
                    NewsArticleTag::query()->create([
                        'news_article_id' => $article->id,
                        'tag_name' => $tag,
                        'sort_order' => $index + 1,
                    ]);
                }

                $keptBlockIds = [];
                foreach (array_values($articleData['blocks']) as $blockIndex => $blockData) {
                    $block = NewsArticleBlock::query()->updateOrCreate(
                        [
                            'news_article_id' => $article->id,
                            'sort_order' => $blockIndex + 1,
                        ],
                        [
                            'block_type' => $blockData['type'],
                            'is_active' => true,
                            'payload' => $blockData['payload'],
                            'updated_by' => $adminId,
                        ]
                    );

                    $keptBlockIds[] = $block->id;

                    $keptMediaIds = [];

                    foreach (array_values($blockData['media'] ?? []) as $mediaIndex => $path) {
                        $asset = $this->imageAsset($articleData['slug'].'-media-'.($blockIndex + 1).'-'.($mediaIndex + 1).'.jpg', $path, $adminId);
                        $media = NewsArticleBlockMedia::query()->updateOrCreate(
                            [
                                'news_article_block_id' => $block->id,
                                'sort_order' => $mediaIndex + 1,
                            ],
                            [
                                'asset_id' => $asset->id,
                                'caption' => $blockData['captions'][$mediaIndex] ?? ($blockData['payload']['subtext'] ?? null),
                                'alt_text' => $blockData['payload']['alt_text'] ?? $articleData['title'],
                            ]
                        );

                        $keptMediaIds[] = $media->id;
                    }

                    NewsArticleBlockMedia::query()
                        ->where('news_article_block_id', $block->id)
                        ->when(count($keptMediaIds) > 0, fn ($query) => $query->whereNotIn('id', $keptMediaIds))
                        ->when(count($keptMediaIds) === 0, fn ($query) => $query)
                        ->delete();
                }

                NewsArticleBlock::query()
                    ->where('news_article_id', $article->id)
                    ->whereNotIn('id', $keptBlockIds)
                    ->delete();
            }

            $studentSubmitter = Siswa::query()
                ->where('nama', 'Aulia Rahma')
                ->where('kelas', 'XI RPL 2')
                ->first();
            $studentArticle = NewsArticle::query()->updateOrCreate(
                ['slug' => 'prototype-robotik-siswa-pending-review'],
                [
                    'category_id' => null,
                    'category_name' => 'Inovasi Siswa',
                    'title' => 'Prototype Robotik Siswa untuk Sortir Barang Menunggu Review',
                    'excerpt' => 'Contoh kiriman siswa yang belum tayang publik karena masih menunggu persetujuan admin.',
                    'author_name' => 'Kiriman Siswa',
                    'workflow_status' => 'pending_review',
                    'source_type' => 'student',
                    'submitted_by_type' => $studentSubmitter ? Siswa::class : null,
                    'submitted_by_id' => $studentSubmitter?->id,
                    'submitted_at' => now(),
                    'submitter_name' => 'Aulia Rahma',
                    'submitter_class' => 'XI RPL 2',
                    'submitter_contact' => '081234567890',
                    'created_by' => $adminId,
                    'updated_by' => $adminId,
                ]
            );

            NewsArticleBlock::query()->where('news_article_id', $studentArticle->id)->delete();
            NewsArticleBlock::query()->create([
                'news_article_id' => $studentArticle->id,
                'block_type' => 'text',
                'sort_order' => 1,
                'is_active' => true,
                'payload' => [
                    'heading' => 'Draft kiriman siswa',
                    'body' => 'Artikel ini disiapkan sebagai contoh workflow moderasi. Admin dapat mengedit, menolak, atau mem-publish setelah review selesai.',
                ],
                'updated_by' => $adminId,
            ]);

            NewsFeaturedArticle::query()->delete();
            foreach (array_slice($publishedIds, 0, 4) as $index => $articleId) {
                NewsFeaturedArticle::query()->create([
                    'slot_order' => $index + 1,
                    'news_article_id' => $articleId,
                    'updated_by' => $adminId,
                ]);
            }
        });
    }

    private function imageAsset(string $originalName, string $jpegPath, ?int $updatedBy = null): PageAsset
    {
        return PageAsset::query()->updateOrCreate(
            [
                'page_key' => 'news',
                'original_name' => $originalName,
            ],
            [
                'asset_type' => 'image',
                'disk' => 'public',
                'mime_type' => 'image/jpeg',
                'size_bytes' => 0,
                'jpeg_path' => $jpegPath,
                'webp_path' => 'images/webp/default_picture.webp',
                'updated_by' => $updatedBy,
                'meta' => ['seeded' => true],
            ]
        );
    }
}
