<?php

namespace Database\Seeders;

use App\Models\PageImage;
use Illuminate\Database\Seeder;

class PageImageSeeder extends Seeder
{
    private const DEFAULT_JPEG_PATH = 'images/alternative/default_picture.jpeg';
    private const DEFAULT_WEBP_PATH = 'images/webp/default_picture.webp';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $landingSlots = [
            [
                'page_key' => 'landing',
                'slot_key' => 'hero_main',
                'section' => 'Hero',
                'title' => 'Hero Utama',
                'alt_text' => 'Sekolah SMKN 1 Wringin',
                'jpeg_path' => self::DEFAULT_JPEG_PATH,
                'webp_path' => self::DEFAULT_WEBP_PATH,
            ],
            [
                'page_key' => 'landing',
                'slot_key' => 'sambutan_kepala_sekolah',
                'section' => 'Sambutan',
                'title' => 'Foto Kepala Sekolah',
                'alt_text' => 'SITI ANY MAYA SHULHAH, S.Sn., M.Pd., M.Sc.',
                'jpeg_path' => self::DEFAULT_JPEG_PATH,
                'webp_path' => self::DEFAULT_WEBP_PATH,
            ],
            [
                'page_key' => 'landing',
                'slot_key' => 'profil_guru',
                'section' => 'Profil',
                'title' => 'Profil Guru',
                'alt_text' => 'Guru Mengajar',
                'jpeg_path' => self::DEFAULT_JPEG_PATH,
                'webp_path' => self::DEFAULT_WEBP_PATH,
            ],
            [
                'page_key' => 'landing',
                'slot_key' => 'profil_praktek',
                'section' => 'Profil',
                'title' => 'Profil Praktik',
                'alt_text' => 'Praktek SMK',
                'jpeg_path' => self::DEFAULT_JPEG_PATH,
                'webp_path' => self::DEFAULT_WEBP_PATH,
            ],
        ];

        foreach ($landingSlots as $slot) {
            $this->seedSlot($slot);
        }

        $jurusanMeta = [
            'tav' => 'TAV',
            'dkv' => 'DKV',
            'tkj' => 'TKJ',
            'tkro' => 'TKRO',
        ];

        foreach ($jurusanMeta as $slug => $short) {
            $this->seedSlot([
                'page_key' => 'jurusan_detail',
                'slot_key' => $slug.'_hero_image',
                'section' => 'Mengenal Jurusan',
                'title' => 'Foto Jurusan '.$short,
                'alt_text' => 'Foto kegiatan jurusan '.$short,
                'jpeg_path' => self::DEFAULT_JPEG_PATH,
                'webp_path' => self::DEFAULT_WEBP_PATH,
                'force_sync' => true,
            ]);

            for ($i = 1; $i <= 5; $i++) {
                $this->seedSlot([
                    'page_key' => 'jurusan_detail',
                    'slot_key' => $slug.'_gallery_'.$i,
                    'section' => 'Galeri Jurusan',
                    'title' => 'Galeri '.$short.' '.$i,
                    'alt_text' => 'Galeri '.$short.' '.$i,
                    'jpeg_path' => self::DEFAULT_JPEG_PATH,
                    'webp_path' => self::DEFAULT_WEBP_PATH,
                ]);
            }
        }

        $ekstrakurikulerMeta = [
            [
                'slug' => 'pramuka',
                'slot_key' => 'ekskul_pramuka',
                'name' => 'Pramuka',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'pmr',
                'slot_key' => 'ekskul_pmr',
                'name' => 'Palang Merah Remaja',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'hadrah',
                'slot_key' => 'ekskul_hadrah',
                'name' => 'Seni Hadrah',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'futsal',
                'slot_key' => 'ekskul_futsal',
                'name' => 'Sepak Bola & Futsal',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'basket',
                'slot_key' => 'ekskul_basket',
                'name' => 'Bola Basket',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'voli',
                'slot_key' => 'ekskul_voli',
                'name' => 'Bola Voli',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'esports',
                'slot_key' => 'ekskul_esports',
                'name' => 'E-Sports Club',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'tari-vokal',
                'slot_key' => 'ekskul_tari_vokal',
                'name' => 'Seni Tari & Vokal',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'vm-media',
                'slot_key' => 'ekskul_vm_media',
                'name' => 'VM Media',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slug' => 'sains-club',
                'slot_key' => 'ekskul_sains_club',
                'name' => 'Sains Club',
                'list_image' => self::DEFAULT_JPEG_PATH,
                'hero_image' => self::DEFAULT_JPEG_PATH,
            ],
        ];

        foreach ($ekstrakurikulerMeta as $item) {
            $this->seedSlot([
                'page_key' => 'ekstrakurikuler',
                'slot_key' => $item['slot_key'],
                'section' => 'Daftar Ekskul',
                'title' => 'Kartu Ekskul - '.$item['name'],
                'alt_text' => 'Kegiatan '.$item['name'],
                'jpeg_path' => $item['list_image'],
                'webp_path' => self::DEFAULT_WEBP_PATH,
                'force_sync' => true,
            ]);

            $this->seedSlot([
                'page_key' => 'ekstrakurikuler_detail',
                'slot_key' => $item['slug'].'_hero_image',
                'section' => 'Hero',
                'title' => 'Hero '.$item['name'],
                'alt_text' => 'Kegiatan '.$item['name'],
                'jpeg_path' => $item['hero_image'],
                'webp_path' => self::DEFAULT_WEBP_PATH,
                'force_sync' => true,
            ]);

            foreach ($this->defaultGalleryTemplate($item['name']) as $galleryItem) {
                $this->seedSlot([
                    'page_key' => 'ekstrakurikuler_detail',
                    'slot_key' => $item['slug'].'_'.$galleryItem['slot'],
                    'section' => 'Galeri Kegiatan',
                    'title' => $galleryItem['title'],
                    'alt_text' => $galleryItem['alt_text'],
                    'jpeg_path' => $galleryItem['image'],
                    'webp_path' => self::DEFAULT_WEBP_PATH,
                    'force_sync' => true,
                ]);
            }
        }
    }

    /**
     * @param array<string, mixed> $slot
     */
    private function seedSlot(array $slot): void
    {
        $forceSync = (bool) ($slot['force_sync'] ?? false);

        $model = PageImage::query()->firstOrCreate(
            [
                'page_key' => $slot['page_key'],
                'slot_key' => $slot['slot_key'],
            ],
            [
                'section' => $slot['section'],
                'title' => $slot['title'],
                'alt_text' => $slot['alt_text'],
                'disk' => 'public',
                'jpeg_path' => $slot['jpeg_path'] ?? null,
                'webp_path' => $slot['webp_path'] ?? null,
                'is_active' => true,
            ]
        );

        $needsBackfill = (! $model->jpeg_path && ! empty($slot['jpeg_path']))
            || (! $model->webp_path && ! empty($slot['webp_path']));

        if ($forceSync || $needsBackfill) {
            $model->fill([
                'section' => $slot['section'],
                'title' => $slot['title'],
                'alt_text' => $slot['alt_text'],
                'disk' => 'public',
                'jpeg_path' => $slot['jpeg_path'],
                'webp_path' => $slot['webp_path'] ?? null,
                'is_active' => true,
            ]);

            if ($model->isDirty()) {
                $model->save();
                $model->increment('cache_version');
            }
        }
    }

    /**
     * @return array<int, array{slot:string,title:string,alt_text:string,image:string}>
     */
    private function defaultGalleryTemplate(string $name): array
    {
        return [
            [
                'slot' => 'gallery_1',
                'title' => 'Galeri '.$name.' 1',
                'alt_text' => 'Latihan rutin '.$name,
                'image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slot' => 'gallery_2',
                'title' => 'Galeri '.$name.' 2',
                'alt_text' => 'Sesi pembinaan '.$name,
                'image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slot' => 'gallery_3',
                'title' => 'Galeri '.$name.' 3',
                'alt_text' => 'Kolaborasi tim '.$name,
                'image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slot' => 'gallery_4',
                'title' => 'Galeri '.$name.' 4',
                'alt_text' => 'Proyek kegiatan '.$name,
                'image' => self::DEFAULT_JPEG_PATH,
            ],
            [
                'slot' => 'gallery_5',
                'title' => 'Galeri '.$name.' 5',
                'alt_text' => 'Dokumentasi '.$name,
                'image' => self::DEFAULT_JPEG_PATH,
            ],
        ];
    }
}
