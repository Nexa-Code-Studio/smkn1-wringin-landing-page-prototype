<?php

namespace Database\Seeders;

use App\Models\HomeFeaturedExtracurricular;
use App\Models\HomePageSetting;
use Illuminate\Database\Seeder;

class HomePageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = HomePageSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'hero_badge_text' => 'Penerimaan Siswa Baru Tahun 2025',
                'is_badge_visible' => true,
                'total_ekskul' => 10,
                'siswa_aktif' => 1200,
                'total_prestasi' => 85,
                'mitra_industri' => '25+',
                'alamat' => 'Jl. Pendidikan No. 45, Wringin, Bondowoso, Jawa Timur',
                'nomor_telepon' => '(0332) 555-0199',
                'email' => 'admin@smkn1wringin.sch.id',
                'persen_melanjutkan_kuliah' => 32,
                'persen_bekerja_berwirausaha' => 68,
                'tahun_mengabdi' => 25,
                'tahun_ppdb' => (int) date('Y'),
                'cache_version' => 1,
            ]
        );

        $featured = [
            1 => 'Pramuka',
            2 => 'E-Sports Club',
            3 => 'Bola Basket',
        ];

        foreach ($featured as $order => $name) {
            HomeFeaturedExtracurricular::query()->updateOrCreate(
                [
                    'home_page_setting_id' => $setting->id,
                    'sort_order' => $order,
                ],
                [
                    'name' => $name,
                    'is_active' => true,
                ]
            );
        }
    }
}
