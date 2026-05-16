<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'hero_badge_text',
    'is_badge_visible',
    'total_ekskul',
    'siswa_aktif',
    'total_prestasi',
    'mitra_industri',
    'alamat',
    'nomor_telepon',
    'email',
    'persen_melanjutkan_kuliah',
    'persen_bekerja_berwirausaha',
    'tahun_mengabdi',
    'cache_version',
    'updated_by',
])]
class HomePageSetting extends Model
{
    protected function casts(): array
    {
        return [
            'is_badge_visible' => 'boolean',
            'total_ekskul' => 'integer',
            'siswa_aktif' => 'integer',
            'total_prestasi' => 'integer',
            'persen_melanjutkan_kuliah' => 'integer',
            'persen_bekerja_berwirausaha' => 'integer',
            'tahun_mengabdi' => 'integer',
            'cache_version' => 'integer',
        ];
    }

    public function featuredExtracurriculars(): HasMany
    {
        return $this->hasMany(HomeFeaturedExtracurricular::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function allFeaturedExtracurriculars(): HasMany
    {
        return $this->hasMany(HomeFeaturedExtracurricular::class)
            ->orderBy('sort_order');
    }
}
