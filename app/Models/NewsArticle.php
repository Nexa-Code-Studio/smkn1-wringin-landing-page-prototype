<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'category_id',
    'category_name',
    'title',
    'slug',
    'excerpt',
    'author_name',
    'cover_asset_id',
    'cover_alt_text',
    'workflow_status',
    'source_type',
    'submitted_by_type',
    'submitted_by_id',
    'published_at',
    'submitted_at',
    'reviewed_at',
    'reviewed_by',
    'rejection_note',
    'submitter_name',
    'submitter_class',
    'submitter_contact',
    'created_by',
    'updated_by',
    'meta',
])]
class NewsArticle extends Model
{
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function coverAsset(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PageAsset::class, 'cover_asset_id');
    }

    public function submittedBy(): MorphTo
    {
        return $this->morphTo();
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(NewsArticleBlock::class, 'news_article_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function allBlocks(): HasMany
    {
        return $this->hasMany(NewsArticleBlock::class, 'news_article_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(NewsArticleTag::class, 'news_article_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function featuredSlot(): HasMany
    {
        return $this->hasMany(NewsFeaturedArticle::class, 'news_article_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('workflow_status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isStudentSubmission(): bool
    {
        return $this->submitted_by_type === Siswa::class || $this->source_type === 'student';
    }
}
