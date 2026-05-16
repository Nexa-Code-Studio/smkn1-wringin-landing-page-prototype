<?php

namespace App\Services;

use App\Models\PageAsset;
use App\Models\PageBlock;
use App\Models\PageContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PpdbPageBuilderService
{
    public function __construct(
        private readonly PageBuilderContentService $contentService,
        private readonly PageAssetUploadService $assetUploadService,
    ) {
    }

    public function updateHeader(array $payload, ?int $updatedBy = null): PageContent
    {
        $pageContent = $this->pageContent();
        $meta = $pageContent->meta ?? [];
        $meta['badge_text'] = trim((string) ($payload['badge_text'] ?? 'Informasi Resmi PPDB'));

        $pageContent->fill([
            'title' => trim((string) $payload['title']),
            'meta' => $meta,
            'updated_by' => $updatedBy,
        ]);
        $pageContent->save();

        $this->contentService->bumpVersion($pageContent);

        return $pageContent;
    }

    public function createBlock(string $blockType, array $payload, ?UploadedFile $assetFile = null, ?int $updatedBy = null): PageBlock
    {
        return DB::transaction(function () use ($blockType, $payload, $assetFile, $updatedBy) {
            $pageContent = $this->pageContent();
            $nextOrder = (int) (PageBlock::query()->forPage('ppdb')->max('sort_order') ?? 0) + 1;
            $asset = $this->persistAsset('ppdb', $blockType, $assetFile, $updatedBy);

            $block = PageBlock::query()->create([
                'page_key' => 'ppdb',
                'block_type' => $blockType,
                'sort_order' => $nextOrder,
                'is_active' => true,
                'asset_id' => $asset?->id,
                'payload' => $this->payloadForType($blockType, $payload),
                'updated_by' => $updatedBy,
            ]);

            $pageContent->forceFill([
                'is_initialized' => true,
                'updated_by' => $updatedBy,
            ])->save();

            $this->contentService->bumpVersion($pageContent);

            return $block;
        });
    }

    public function updateBlock(PageBlock $block, array $payload, ?UploadedFile $assetFile = null, ?int $updatedBy = null): PageBlock
    {
        return DB::transaction(function () use ($block, $payload, $assetFile, $updatedBy) {
            $pageContent = $this->pageContent();
            $asset = $assetFile ? $this->persistAsset('ppdb', $block->block_type, $assetFile, $updatedBy) : null;

            $block->fill([
                'payload' => $this->payloadForType($block->block_type, $payload),
                'updated_by' => $updatedBy,
            ]);

            if ($asset) {
                $block->asset_id = $asset->id;
            }

            $block->save();

            $pageContent->forceFill(['updated_by' => $updatedBy])->save();
            $this->contentService->bumpVersion($pageContent);

            return $block;
        });
    }

    public function deleteBlock(PageBlock $block, ?int $updatedBy = null): void
    {
        DB::transaction(function () use ($block, $updatedBy) {
            $pageContent = $this->pageContent();
            $deletedOrder = $block->sort_order;

            $block->delete();

            PageBlock::query()
                ->forPage('ppdb')
                ->where('sort_order', '>', $deletedOrder)
                ->orderBy('sort_order')
                ->get()
                ->each(function (PageBlock $item) use ($updatedBy) {
                    $item->update([
                        'sort_order' => max(1, $item->sort_order - 1),
                        'updated_by' => $updatedBy,
                    ]);
                });

            $pageContent->forceFill([
                'is_initialized' => true,
                'updated_by' => $updatedBy,
            ])->save();
            $this->contentService->bumpVersion($pageContent);
        });
    }

    public function reorderBlocks(array $blockIds, ?int $updatedBy = null): void
    {
        DB::transaction(function () use ($blockIds, $updatedBy) {
            $pageContent = $this->pageContent();

            $blocks = PageBlock::query()
                ->forPage('ppdb')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            if ($blocks->count() !== count($blockIds)) {
                return;
            }

            $ppdbIds = $blocks->pluck('id')->map(fn ($id) => (int) $id)->values()->all();
            $normalizedInput = collect($blockIds)->map(fn ($id) => (int) $id)->values()->all();

            sort($ppdbIds);
            $sortedInput = $normalizedInput;
            sort($sortedInput);

            if ($ppdbIds !== $sortedInput) {
                return;
            }

            foreach ($normalizedInput as $index => $blockId) {
                PageBlock::query()
                    ->whereKey($blockId)
                    ->update([
                        'sort_order' => $index + 1,
                        'updated_by' => $updatedBy,
                    ]);
            }

            $pageContent->forceFill([
                'is_initialized' => true,
                'updated_by' => $updatedBy,
            ])->save();
            $this->contentService->bumpVersion($pageContent);
        });
    }

    public function pageContent(): PageContent
    {
        return PageContent::query()->firstOrCreate(
            ['page_key' => 'ppdb'],
            [
                'title' => 'Informasi Lengkap Pendaftaran Jalur Prestasi & Reguler',
                'is_initialized' => false,
                'cache_version' => 1,
                'meta' => ['badge_text' => 'Informasi Resmi PPDB'],
            ]
        );
    }

    private function persistAsset(string $pageKey, string $blockType, ?UploadedFile $assetFile, ?int $updatedBy): ?PageAsset
    {
        if (! $assetFile) {
            return null;
        }

        return match ($blockType) {
            'image' => $this->assetUploadService->storeImage($pageKey, $assetFile, $updatedBy),
            'file' => $this->assetUploadService->storeFile($pageKey, $assetFile, $updatedBy),
            default => null,
        };
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
            'file' => [
                'label' => trim((string) ($payload['label'] ?? '')),
                'description' => trim((string) ($payload['description'] ?? '')),
                'button_text' => trim((string) ($payload['button_text'] ?? 'Unduh File')),
            ],
            'link' => [
                'label' => trim((string) ($payload['label'] ?? '')),
                'url' => trim((string) ($payload['url'] ?? '')),
                'description' => trim((string) ($payload['description'] ?? '')),
                'style_variant' => trim((string) ($payload['style_variant'] ?? 'brand')) ?: 'brand',
            ],
            default => [],
        };
    }
}
