<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'page_key',
    'block_type',
    'sort_order',
    'is_active',
    'asset_id',
    'updated_by',
    'payload',
])]
class PageBlock extends Model
{
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'payload' => 'array',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(PageAsset::class, 'asset_id');
    }

    public function scopeForPage(Builder $query, string $pageKey): Builder
    {
        return $query->where('page_key', $pageKey);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
