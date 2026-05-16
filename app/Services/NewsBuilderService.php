<?php

namespace App\Services;

use App\Models\NewsArticle;
use App\Models\NewsArticleBlock;
use App\Models\NewsArticleBlockMedia;
use App\Models\NewsArticleTag;
use App\Models\NewsFeaturedArticle;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsBuilderService
{
    public function __construct(
        private readonly PageAssetUploadService $assetUploadService,
    ) {
    }

    public function saveArticle(?NewsArticle $article, array $payload, ?UploadedFile $coverFile = null, ?int $updatedBy = null, User|Siswa|null $submittedBy = null, ?string $forcedWorkflowStatus = null): NewsArticle
    {
        return DB::transaction(function () use ($article, $payload, $coverFile, $updatedBy, $submittedBy, $forcedWorkflowStatus) {
            $article ??= new NewsArticle();
            $isCreating = ! $article->exists;
            $title = trim((string) $payload['title']);
            $resolvedSubmittedBy = $submittedBy ?? $article->submittedBy;
            $workflowStatus = trim((string) ($forcedWorkflowStatus ?? ($payload['workflow_status'] ?? 'draft'))) ?: 'draft';
            $sourceType = $resolvedSubmittedBy instanceof Siswa
                ? 'student'
                : ($resolvedSubmittedBy instanceof User ? 'admin' : trim((string) ($article->source_type ?: 'admin')));
            $publishedAt = $this->resolvePublishedAt($workflowStatus, $payload['published_at'] ?? null, $article->published_at);
            $reviewedAt = $this->resolveReviewedAt($sourceType, $workflowStatus, $article->reviewed_at);

            $article->fill([
                'category_name' => trim((string) ($payload['category'] ?? '')),
                'title' => $title,
                'slug' => $this->uniqueSlug(
                    trim((string) ($payload['slug'] ?? '')) ?: $title,
                    $article->id,
                ),
                'excerpt' => trim((string) ($payload['excerpt'] ?? '')),
                'author_name' => trim((string) ($payload['author_name'] ?? '')),
                'cover_alt_text' => trim((string) ($payload['cover_alt_text'] ?? '')),
                'workflow_status' => $workflowStatus,
                'source_type' => $sourceType,
                'submitted_by_type' => $submittedBy ? $submittedBy::class : $article->submitted_by_type,
                'submitted_by_id' => $submittedBy ? $submittedBy->getKey() : $article->submitted_by_id,
                'published_at' => $publishedAt,
                'submitted_at' => $this->resolveSubmittedAt($sourceType, $workflowStatus, $article->submitted_at),
                'reviewed_at' => $reviewedAt,
                'reviewed_by' => $reviewedAt ? $updatedBy : null,
                'rejection_note' => $sourceType === 'student' && $workflowStatus === 'rejected'
                    ? trim((string) ($payload['rejection_note'] ?? ''))
                    : null,
                'submitter_name' => $article->submitter_name,
                'submitter_class' => $article->submitter_class,
                'submitter_contact' => $article->submitter_contact,
                'category_id' => null,
                'created_by' => $isCreating ? $updatedBy : $article->created_by,
                'updated_by' => $updatedBy,
            ]);
            $article->save();

            if ($coverFile) {
                $coverAsset = $this->assetUploadService->storeImage('news', $coverFile, $updatedBy);
                $article->forceFill(['cover_asset_id' => $coverAsset->id])->save();
            }

            $this->syncTags($article, $payload['tags'] ?? '');

            if ($article->workflow_status !== 'published') {
                NewsFeaturedArticle::query()
                    ->where('news_article_id', $article->id)
                    ->delete();
            }

            return $article->fresh(['category', 'coverAsset', 'tags', 'blocks.media.asset', 'submittedBy']);
        });
    }

    public function deleteArticle(NewsArticle $article): void
    {
        DB::transaction(function () use ($article) {
            NewsFeaturedArticle::query()->where('news_article_id', $article->id)->delete();
            $article->delete();
        });
    }

    /**
     * @param  array<int, int|null>  $slots
     */
    public function updateFeaturedArticles(array $slots, ?int $updatedBy = null): void
    {
        DB::transaction(function () use ($slots, $updatedBy) {
            $normalized = collect($slots)
                ->mapWithKeys(fn ($articleId, $slot) => [(int) $slot => $articleId ? (int) $articleId : null])
                ->all();

            NewsFeaturedArticle::query()
                ->whereNotIn('slot_order', array_keys($normalized))
                ->delete();

            foreach ($normalized as $slotOrder => $articleId) {
                if (! $articleId) {
                    NewsFeaturedArticle::query()->where('slot_order', $slotOrder)->delete();
                    continue;
                }

                NewsFeaturedArticle::query()->updateOrCreate(
                    ['slot_order' => $slotOrder],
                    [
                        'news_article_id' => $articleId,
                        'updated_by' => $updatedBy,
                    ]
                );
            }
        });
    }

    public function createBlock(NewsArticle $article, string $blockType, array $payload, ?UploadedFile $assetFile = null, array $assetFiles = [], ?int $updatedBy = null): NewsArticleBlock
    {
        return DB::transaction(function () use ($article, $blockType, $payload, $assetFile, $assetFiles, $updatedBy) {
            $nextOrder = (int) ($article->allBlocks()->max('sort_order') ?? 0) + 1;

            $block = NewsArticleBlock::query()->create([
                'news_article_id' => $article->id,
                'block_type' => $blockType,
                'sort_order' => $nextOrder,
                'is_active' => true,
                'payload' => $this->payloadForType($blockType, $payload),
                'updated_by' => $updatedBy,
            ]);

            $this->syncBlockMedia($article, $block, $blockType, $payload, $assetFile, $assetFiles, $updatedBy, true);

            return $block->fresh(['media.asset']);
        });
    }

    public function updateBlock(NewsArticleBlock $block, array $payload, ?UploadedFile $assetFile = null, array $assetFiles = [], ?int $updatedBy = null): NewsArticleBlock
    {
        return DB::transaction(function () use ($block, $payload, $assetFile, $assetFiles, $updatedBy) {
            $block->fill([
                'payload' => $this->payloadForType($block->block_type, $payload),
                'updated_by' => $updatedBy,
            ]);
            $block->save();

            $this->syncBlockMedia($block->article, $block, $block->block_type, $payload, $assetFile, $assetFiles, $updatedBy, false);

            return $block->fresh(['media.asset']);
        });
    }

    public function deleteBlock(NewsArticleBlock $block, ?int $updatedBy = null): void
    {
        DB::transaction(function () use ($block, $updatedBy) {
            $articleId = $block->news_article_id;
            $deletedOrder = $block->sort_order;

            $block->delete();

            NewsArticleBlock::query()
                ->where('news_article_id', $articleId)
                ->where('sort_order', '>', $deletedOrder)
                ->orderBy('sort_order')
                ->get()
                ->each(function (NewsArticleBlock $item) use ($updatedBy) {
                    $item->update([
                        'sort_order' => max(1, $item->sort_order - 1),
                        'updated_by' => $updatedBy,
                    ]);
                });
        });
    }

    /**
     * @param  array<int, int>  $blockIds
     */
    public function reorderBlocks(NewsArticle $article, array $blockIds, ?int $updatedBy = null): void
    {
        DB::transaction(function () use ($article, $blockIds, $updatedBy) {
            $blocks = NewsArticleBlock::query()
                ->where('news_article_id', $article->id)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            if ($blocks->count() !== count($blockIds)) {
                return;
            }

            $existingIds = $blocks->pluck('id')->map(fn ($id) => (int) $id)->sort()->values()->all();
            $submittedIds = collect($blockIds)->map(fn ($id) => (int) $id)->sort()->values()->all();

            if ($existingIds !== $submittedIds) {
                return;
            }

            foreach (array_values($blockIds) as $index => $blockId) {
                NewsArticleBlock::query()->whereKey($blockId)->update([
                    'sort_order' => $index + 1,
                    'updated_by' => $updatedBy,
                ]);
            }
        });
    }

    private function syncTags(NewsArticle $article, string $rawTags): void
    {
        $tags = collect(preg_split('/[,\n\r]+/', $rawTags) ?: [])
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->map(fn (string $tag) => str_starts_with($tag, '#') ? $tag : '#'.$tag)
            ->unique(fn (string $tag) => Str::lower($tag))
            ->values();

        NewsArticleTag::query()->where('news_article_id', $article->id)->delete();

        foreach ($tags as $index => $tag) {
            NewsArticleTag::query()->create([
                'news_article_id' => $article->id,
                'tag_name' => $tag,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * @param  array<int, UploadedFile>  $assetFiles
     */
    private function syncBlockMedia(NewsArticle $article, NewsArticleBlock $block, string $blockType, array $payload, ?UploadedFile $assetFile, array $assetFiles, ?int $updatedBy, bool $creating): void
    {
        if ($blockType === 'text' || $blockType === 'highlight_text') {
            return;
        }

        if ($blockType === 'image') {
            $this->syncSingleImageMedia(
                $article,
                $block,
                $payload,
                $assetFile,
                $updatedBy,
                $creating,
            );

            return;
        }

        if ($blockType === 'image_showcase') {
            $this->syncMultiImageMedia(
                $article,
                $block,
                $payload,
                $assetFiles,
                trim((string) ($payload['alt_text'] ?? '')) ?: $article->title,
                $updatedBy,
                $creating,
                false,
            );
        }
    }

    private function payloadForType(string $blockType, array $payload): array
    {
        return match ($blockType) {
            'text' => [
                'heading' => trim((string) ($payload['heading'] ?? '')),
                'body' => trim((string) ($payload['body'] ?? '')),
            ],
            'image' => [
                'caption' => trim((string) ($payload['caption'] ?? '')),
                'alt_text' => trim((string) ($payload['alt_text'] ?? '')),
            ],
            'image_showcase' => [
                'alt_text' => trim((string) ($payload['alt_text'] ?? '')),
            ],
            'highlight_text' => [
                'text' => trim((string) ($payload['text'] ?? '')),
            ],
            default => [],
        };
    }

    private function resolvePublishedAt(string $workflowStatus, mixed $publishedAtInput, mixed $currentPublishedAt): mixed
    {
        if ($workflowStatus !== 'published') {
            return null;
        }

        if ($publishedAtInput) {
            return $publishedAtInput;
        }

        return $currentPublishedAt ?: now();
    }

    private function resolveSubmittedAt(string $sourceType, string $workflowStatus, mixed $currentSubmittedAt): mixed
    {
        if ($sourceType === 'student' && $workflowStatus === 'pending_review') {
            return $currentSubmittedAt ?: now();
        }

        return $currentSubmittedAt;
    }

    private function resolveReviewedAt(string $sourceType, string $workflowStatus, mixed $currentReviewedAt): mixed
    {
        if ($sourceType === 'student' && in_array($workflowStatus, ['published', 'rejected'], true)) {
            return now();
        }

        if ($workflowStatus === 'rejected') {
            return now();
        }

        return $workflowStatus === 'pending_review' ? null : $currentReviewedAt;
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source);
        $base = $base !== '' ? $base : 'berita';
        $slug = $base;
        $counter = 2;

        while (NewsArticle::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * @param  array<int, UploadedFile>  $assetFiles
     */
    private function syncSingleImageMedia(NewsArticle $article, NewsArticleBlock $block, array $payload, ?UploadedFile $assetFile, ?int $updatedBy, bool $creating): void
    {
        $caption = trim((string) ($payload['caption'] ?? ''));
        $altText = trim((string) ($payload['alt_text'] ?? '')) ?: $article->title;

        if (! $creating && ! $assetFile) {
            $existingMedia = $block->media()->orderBy('sort_order')->orderBy('id')->get();

            if ($existingMedia->isEmpty()) {
                return;
            }

            $existingMedia->each(function (NewsArticleBlockMedia $media, int $index) use ($caption, $altText) {
                $media->update([
                    'caption' => $index === 0 ? $caption : null,
                    'alt_text' => $altText,
                ]);
            });

            return;
        }

        if (! $assetFile) {
            return;
        }

        NewsArticleBlockMedia::query()->where('news_article_block_id', $block->id)->delete();

        $asset = $this->assetUploadService->storeImage('news', $assetFile, $updatedBy);
        NewsArticleBlockMedia::query()->create([
            'news_article_block_id' => $block->id,
            'asset_id' => $asset->id,
            'sort_order' => 1,
            'caption' => $caption,
            'alt_text' => $altText,
        ]);
    }

    /**
     * @param  array<int, UploadedFile>  $assetFiles
     */
    private function syncMultiImageMedia(NewsArticle $article, NewsArticleBlock $block, array $payload, array $assetFiles, string $fallbackAltText, ?int $updatedBy, bool $creating, bool $syncCaptions = true, string $captionField = 'image_captions'): void
    {
        $captions = $syncCaptions
            ? $this->captionLines((string) ($payload[$captionField] ?? ''))
            : [];

        if (! $creating && count($assetFiles) === 0) {
            $existingMedia = $block->media()->orderBy('sort_order')->orderBy('id')->get();

            if ($existingMedia->isEmpty()) {
                return;
            }

            $existingMedia->each(function (NewsArticleBlockMedia $media, int $index) use ($captions, $fallbackAltText, $syncCaptions) {
                $media->update([
                    'caption' => $syncCaptions ? ($captions[$index] ?? $media->caption) : null,
                    'alt_text' => $fallbackAltText !== '' ? $fallbackAltText : $media->alt_text,
                ]);
            });

            return;
        }

        if (count($assetFiles) === 0) {
            return;
        }

        NewsArticleBlockMedia::query()->where('news_article_block_id', $block->id)->delete();

        foreach (array_values($assetFiles) as $index => $file) {
            $asset = $this->assetUploadService->storeImage('news', $file, $updatedBy);
            NewsArticleBlockMedia::query()->create([
                'news_article_block_id' => $block->id,
                'asset_id' => $asset->id,
                'sort_order' => $index + 1,
                'caption' => $syncCaptions ? ($captions[$index] ?? null) : null,
                'alt_text' => $fallbackAltText,
            ]);
        }
    }

    /**
     * @return array<int, string>
     */
    private function captionLines(string $raw): array
    {
        return collect(preg_split('/\R+/', trim($raw)) ?: [])
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
