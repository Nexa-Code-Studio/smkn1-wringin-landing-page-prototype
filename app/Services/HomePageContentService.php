<?php

namespace App\Services;

use App\Models\HomePageSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class HomePageContentService
{
    private const VERSION_KEY = 'home_page:version';
    private const PAYLOAD_KEY_PREFIX = 'home_page:payload:v';

    public function getPayload(): array
    {
        if (! Schema::hasTable('home_page_settings')) {
            return $this->defaultPayload();
        }

        $version = $this->currentVersion();
        $payloadKey = $this->payloadKey($version);

        $payload = Cache::rememberForever($payloadKey, function () {
            $setting = HomePageSetting::query()
                ->with('featuredExtracurriculars')
                ->first();

            if (! $setting) {
                return $this->defaultPayload();
            }

            return [
                'hero_badge_text' => $setting->hero_badge_text,
                'is_badge_visible' => $setting->is_badge_visible,
                'total_ekskul' => $setting->total_ekskul,
                'siswa_aktif' => $setting->siswa_aktif,
                'total_prestasi' => $setting->total_prestasi,
                'mitra_industri' => $setting->mitra_industri,
                'alamat' => $setting->alamat,
                'nomor_telepon' => $setting->nomor_telepon,
                'email' => $setting->email,
                'persen_melanjutkan_kuliah' => $setting->persen_melanjutkan_kuliah,
                'persen_bekerja_berwirausaha' => $setting->persen_bekerja_berwirausaha,
                'tahun_mengabdi' => $setting->tahun_mengabdi,
                'featured_ekskul' => $setting->featuredExtracurriculars
                    ->pluck('name')
                    ->values()
                    ->all(),
                'cache_version' => (int) $setting->cache_version,
            ];
        });

        return array_merge($this->defaultPayload(), $payload);
    }

    public function currentVersion(): int
    {
        if (! Schema::hasTable('home_page_settings')) {
            return 1;
        }

        return (int) Cache::rememberForever(self::VERSION_KEY, function () {
            $version = HomePageSetting::query()->value('cache_version');

            return max(1, (int) ($version ?? 1));
        });
    }

    public function bumpVersion(HomePageSetting $setting): int
    {
        if (! Schema::hasTable('home_page_settings')) {
            return 1;
        }

        $oldVersion = max(1, (int) $setting->cache_version);
        $setting->increment('cache_version');
        $setting->refresh();

        $newVersion = max(1, (int) $setting->cache_version);

        Cache::forever(self::VERSION_KEY, $newVersion);
        $this->forgetPayloadForVersion($oldVersion);

        return $newVersion;
    }

    public function forgetPayloadForVersion(int $version): void
    {
        Cache::forget($this->payloadKey($version));
    }

    private function payloadKey(int $version): string
    {
        return self::PAYLOAD_KEY_PREFIX.max(1, $version);
    }

    private function defaultPayload(): array
    {
        return [
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
            'featured_ekskul' => [],
            'cache_version' => 1,
        ];
    }
}
