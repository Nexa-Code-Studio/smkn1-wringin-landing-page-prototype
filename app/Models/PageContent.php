<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'page_key',
    'title',
    'is_initialized',
    'cache_version',
    'updated_by',
    'meta',
])]
class PageContent extends Model
{
    protected function casts(): array
    {
        return [
            'is_initialized' => 'boolean',
            'cache_version' => 'integer',
            'meta' => 'array',
        ];
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(PageBlock::class, 'page_key', 'page_key')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
