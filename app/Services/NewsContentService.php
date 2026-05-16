<?php

namespace App\Services;

use App\Models\NewsArticle;
use App\Models\NewsArticleBlock;
use App\Models\NewsFeaturedArticle;
use App\Models\PageAsset;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class NewsContentService
{
    public function tablesReady(): bool
    {
        return Schema::hasTable('news_articles')
            && Schema::hasTable('news_featured_articles')
            && Schema::hasTable('news_article_blocks')
            && Schema::hasTable('news_article_block_media')
            && Schema::hasTable('news_article_tags')
            && Schema::hasTable('page_assets');
    }

    /**
     * @return Collection<int, string>
     */
    public function categories(): Collection
    {
        if (! $this->tablesReady()) {
            return new Collection();
        }

        return new Collection(
            NewsArticle::query()
                ->select('category_name')
                ->whereNotNull('category_name')
                ->where('category_name', '!=', '')
                ->distinct()
                ->orderBy('category_name')
                ->pluck('category_name')
                ->all()
        );
    }

    /**
     * @return Collection<int, NewsFeaturedArticle>
     */
    public function featuredSlots(): Collection
    {
        if (! $this->tablesReady()) {
            return new Collection();
        }

        return NewsFeaturedArticle::query()
            ->with(['article.coverAsset', 'article.submittedBy'])
            ->ordered()
            ->get();
    }

    /**
     * @return Collection<int, NewsArticle>
     */
    public function featuredArticleOptions(): Collection
    {
        if (! $this->tablesReady()) {
            return new Collection();
        }

        return NewsArticle::query()
            ->with(['submittedBy'])
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();
    }

    /**
     * @return array{featured_articles: array<int, array<string, mixed>>, articles: LengthAwarePaginator, categories: Collection<int, string>, current_category: ?string}
     */
    public function listingPayload(?string $categorySlug = null): array
    {
        $emptyPaginator = new PaginationLengthAwarePaginator(
            items: [],
            total: 0,
            perPage: 6,
            currentPage: 1,
            options: [
                'path' => request()->url(),
                'pageName' => 'page',
            ],
        );

        if (! $this->tablesReady()) {
            return [
                'featured_articles' => [],
                'articles' => $emptyPaginator,
                'categories' => new Collection(),
                'current_category' => null,
            ];
        }

        $categories = $this->categories();
        $currentCategory = $categorySlug
            ? $categories->first(fn (string $category) => strcasecmp($category, $categorySlug) === 0)
            : null;

        $featuredSlots = NewsFeaturedArticle::query()
            ->with([
                'article' => fn ($query) => $query
                    ->with(['coverAsset', 'submittedBy'])
                    ->published(),
            ])
            ->ordered()
            ->get();

        $featuredArticles = $featuredSlots
            ->pluck('article')
            ->filter()
            ->values();

        $featuredArticleIds = $featuredArticles->pluck('id')->map(fn ($id) => (int) $id)->all();

        $articles = NewsArticle::query()
            ->with(['coverAsset', 'tags', 'submittedBy'])
            ->published()
            ->when($currentCategory, fn ($query) => $query->where('category_name', $currentCategory))
            ->when(count($featuredArticleIds) > 0, fn ($query) => $query->whereNotIn('id', $featuredArticleIds))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(6)
            ->withQueryString()
            ->through(fn (NewsArticle $article) => $this->resolveArticleSummary($article));

        return [
            'featured_articles' => $featuredArticles->map(fn (NewsArticle $article) => $this->resolveArticleSummary($article))->all(),
            'articles' => $articles,
            'categories' => $categories,
            'current_category' => $currentCategory,
        ];
    }

    /**
     * @return array{article: NewsArticle, resolved_article: array<string, mixed>, related_articles: array<int, array<string, mixed>>}|null
     */
    public function detailPayload(string $slug): ?array
    {
        if (! $this->tablesReady()) {
            return null;
        }

        $article = NewsArticle::query()
            ->with([
                'coverAsset',
                'tags',
                'blocks.media.asset',
                'submittedBy',
            ])
            ->published()
            ->where('slug', $slug)
            ->first();

        if (! $article) {
            return null;
        }

        $relatedArticles = NewsArticle::query()
            ->with(['coverAsset', 'submittedBy'])
            ->published()
            ->whereKeyNot($article->id)
            ->when(! empty($article->category_name), fn ($query) => $query->where('category_name', $article->category_name))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $excludeIds = $relatedArticles->pluck('id')->push($article->id)->all();
            $fallbackArticles = NewsArticle::query()
                ->with(['coverAsset', 'submittedBy'])
                ->published()
                ->whereNotIn('id', $excludeIds)
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->limit(3 - $relatedArticles->count())
                ->get();

            $relatedArticles = $relatedArticles->concat($fallbackArticles);
        }

        $relatedArticles = $relatedArticles
            ->map(fn (NewsArticle $item) => $this->resolveArticleSummary($item))
            ->all();

        return [
            'article' => $article,
            'resolved_article' => $this->resolveArticle($article),
            'related_articles' => $relatedArticles,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function resolvedBlocks(NewsArticle $article): array
    {
        return $article->allBlocks
            ->where('is_active', true)
            ->map(fn (NewsArticleBlock $block) => $this->resolveBlock($block))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public function resolveArticle(NewsArticle $article): array
    {
        $cover = $article->coverAsset ? $this->resolveAsset($article->coverAsset) : null;

        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'excerpt' => trim((string) ($article->excerpt ?? '')),
            'author_name' => trim((string) ($article->author_name ?? '')) ?: 'Tim Humas SMKN 1 Wringin',
            'category' => trim((string) ($article->category_name ?? '')) ?: 'Berita Sekolah',
            'category_slug' => trim((string) ($article->category_name ?? '')) ?: null,
            'workflow_status' => $article->workflow_status,
            'source_type' => $article->source_type,
            'submitter' => $this->resolveSubmitter($article),
            'is_student_submission' => $article->isStudentSubmission(),
            'rejection_note' => trim((string) ($article->rejection_note ?? '')),
            'published_at' => $article->published_at,
            'published_label' => $article->published_at?->translatedFormat('d F Y'),
            'published_time_label' => $article->published_at?->translatedFormat('H:i') . ' WIB',
            'cover' => $cover,
            'cover_alt_text' => trim((string) ($article->cover_alt_text ?? '')) ?: ($cover['name'] ?? $article->title),
            'tags' => $article->tags->pluck('tag_name')->values()->all(),
            'blocks' => $article->blocks->map(fn (NewsArticleBlock $block) => $this->resolveBlock($block))->filter()->values()->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function resolveArticleSummary(NewsArticle $article): array
    {
        $cover = $article->coverAsset ? $this->resolveAsset($article->coverAsset) : null;

        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'excerpt' => trim((string) ($article->excerpt ?? '')),
            'category' => trim((string) ($article->category_name ?? '')) ?: 'Berita Sekolah',
            'category_slug' => trim((string) ($article->category_name ?? '')) ?: null,
            'cover' => $cover,
            'cover_alt_text' => trim((string) ($article->cover_alt_text ?? '')) ?: ($cover['name'] ?? $article->title),
            'submitter' => $this->resolveSubmitter($article),
            'published_at' => $article->published_at,
            'published_label' => $article->published_at?->translatedFormat('d M Y') ?? '-',
            'workflow_status' => $article->workflow_status,
            'source_type' => $article->source_type,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function resolveBlock(NewsArticleBlock $block): ?array
    {
        $payload = $block->payload ?? [];

        return match ($block->block_type) {
            'text' => [
                'id' => $block->id,
                'type' => 'text',
                'heading' => trim((string) ($payload['heading'] ?? '')),
                'body' => trim((string) ($payload['body'] ?? '')),
                'segments' => $this->segments((string) ($payload['body'] ?? '')),
            ],
            'image' => $this->resolveSingleImageBlock($block, $payload),
            'image_showcase' => [
                'id' => $block->id,
                'type' => 'image_showcase',
                'alt_text' => trim((string) ($payload['alt_text'] ?? '')),
                'items' => $block->media
                    ->map(function ($media) {
                        $asset = $media->asset ? $this->resolveAsset($media->asset) : null;

                        if (! $asset) {
                            return null;
                        }

                        return [
                            'id' => $media->id,
                            'alt_text' => trim((string) ($media->alt_text ?? '')),
                            'asset' => $asset,
                        ];
                    })
                    ->filter()
                    ->values()
                    ->all(),
            ],
            'highlight_text' => [
                'id' => $block->id,
                'type' => 'highlight_text',
                'text' => trim((string) ($payload['text'] ?? '')),
            ],
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>|null
     */
    private function resolveSingleImageBlock(NewsArticleBlock $block, array $payload): ?array
    {
        $media = $block->media
            ->first(fn ($item) => !empty($item->asset));

        $asset = $media?->asset ? $this->resolveAsset($media->asset) : null;

        if (! $asset) {
            return null;
        }

        return [
            'id' => $block->id,
            'type' => 'image',
            'caption' => trim((string) ($media->caption ?? '')) ?: trim((string) ($payload['caption'] ?? '')),
            'alt_text' => trim((string) ($media->alt_text ?? '')) ?: trim((string) ($payload['alt_text'] ?? '')),
            'asset' => $asset,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function resolveAsset(?PageAsset $asset): ?array
    {
        if (! $asset) {
            return null;
        }

        $disk = $asset->disk ?: 'public';

        return [
            'id' => $asset->id,
            'asset_type' => $asset->asset_type,
            'name' => $asset->original_name,
            'mime_type' => $asset->mime_type,
            'size_bytes' => (int) ($asset->size_bytes ?? 0),
            'jpeg_url' => $this->assetUrl($disk, $asset->jpeg_path),
            'webp_url' => $this->assetUrl($disk, $asset->webp_path),
            'original_url' => $this->assetUrl($disk, $asset->original_path),
            'width' => $asset->width,
            'height' => $asset->height,
            'extension' => strtolower(pathinfo((string) $asset->original_name, PATHINFO_EXTENSION)),
        ];
    }

    private function assetUrl(string $disk, ?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk($disk)->url(ltrim($path, '/'));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function segments(string $body): array
    {
        return collect(preg_split('/\R{2,}/', trim($body)) ?: [])
            ->map(function (string $paragraph) {
                $lines = collect(preg_split('/\R/', $paragraph) ?: [])
                    ->map(fn (string $line) => trim($line))
                    ->filter()
                    ->values();

                if ($lines->isNotEmpty() && $lines->every(fn (string $line) => str_starts_with($line, '- '))) {
                    return [
                        'type' => 'list',
                        'items' => $lines->map(fn (string $line) => trim(substr($line, 2)))->values()->all(),
                    ];
                }

                return [
                    'type' => 'paragraph',
                    'content' => trim($paragraph),
                ];
            })
            ->filter(fn (array $segment) => ($segment['type'] ?? '') !== 'paragraph' || ! empty($segment['content']))
            ->values()
            ->all();
    }

    /**
     * @return array{role: string, name: string, identifier: string, is_resolved: bool}
     */
    private function resolveSubmitter(NewsArticle $article): array
    {
        $submitter = $article->submittedBy;

        if ($submitter instanceof User) {
            return [
                'role' => 'Admin',
                'name' => trim((string) $submitter->name) ?: 'Admin',
                'identifier' => trim((string) $submitter->username) ?: '-',
                'is_resolved' => true,
            ];
        }

        if ($submitter instanceof Siswa) {
            return [
                'role' => 'Siswa',
                'name' => trim((string) $submitter->nama) ?: 'Siswa',
                'identifier' => trim((string) $submitter->nisn) ?: '-',
                'is_resolved' => true,
            ];
        }

        if ($article->source_type === 'student') {
            return [
                'role' => 'Siswa',
                'name' => trim((string) ($article->submitter_name ?? '')) ?: 'Siswa belum dipetakan',
                'identifier' => '-',
                'is_resolved' => false,
            ];
        }

        return [
            'role' => 'Admin',
            'name' => trim((string) ($article->author_name ?? '')) ?: 'Admin',
            'identifier' => '-',
            'is_resolved' => false,
        ];
    }
}
