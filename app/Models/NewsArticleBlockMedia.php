<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'news_article_block_id',
    'asset_id',
    'sort_order',
    'caption',
    'alt_text',
    'meta',
])]
class NewsArticleBlockMedia extends Model
{
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'meta' => 'array',
        ];
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(NewsArticleBlock::class, 'news_article_block_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(PageAsset::class, 'asset_id');
    }
}
