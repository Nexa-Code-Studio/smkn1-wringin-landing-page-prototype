<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'slot_order',
    'news_article_id',
    'updated_by',
])]
class NewsFeaturedArticle extends Model
{
    protected function casts(): array
    {
        return [
            'slot_order' => 'integer',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(NewsArticle::class, 'news_article_id');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('slot_order')->orderBy('id');
    }
}
