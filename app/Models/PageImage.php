<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'page_key',
    'slot_key',
    'section',
    'title',
    'alt_text',
    'disk',
    'jpeg_path',
    'webp_path',
    'jpeg_width',
    'jpeg_height',
    'jpeg_bytes',
    'jpeg_quality',
    'webp_width',
    'webp_height',
    'webp_bytes',
    'webp_quality',
    'is_active',
    'cache_version',
    'last_generated_at',
    'updated_by',
    'meta',
])]
class PageImage extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'cache_version' => 'integer',
            'last_generated_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForPage(Builder $query, string $pageKey): Builder
    {
        return $query->where('page_key', $pageKey);
    }
}
