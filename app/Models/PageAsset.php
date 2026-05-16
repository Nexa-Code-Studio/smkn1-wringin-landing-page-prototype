<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'page_key',
    'asset_type',
    'disk',
    'original_name',
    'mime_type',
    'size_bytes',
    'original_path',
    'jpeg_path',
    'webp_path',
    'width',
    'height',
    'updated_by',
    'meta',
])]
class PageAsset extends Model
{
    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'meta' => 'array',
        ];
    }

    public function scopeForPage(Builder $query, string $pageKey): Builder
    {
        return $query->where('page_key', $pageKey);
    }
}
