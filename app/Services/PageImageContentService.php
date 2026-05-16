<?php

namespace App\Services;

use App\Models\PageImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PageImageContentService
{
    private const VERSION_PREFIX = 'page_images:version:';
    private const PAYLOAD_PREFIX = 'page_images:payload:';

    /**
     * @param array<string, array{jpeg:string,webp?:string,alt?:string}> $fallbackSlots
     * @return array<string, array{webp_url:?string,jpeg_url:string,alt_text:string}>
     */
    public function getPageImages(string $pageKey, array $fallbackSlots = []): array
    {
        $fallbackMap = $this->buildFallbackMap($fallbackSlots);

        if (! Schema::hasTable('page_images')) {
            return $fallbackMap;
        }

        $version = $this->currentVersion($pageKey);
        $payloadKey = self::PAYLOAD_PREFIX.$pageKey.':v'.$version;

        $payload = Cache::rememberForever($payloadKey, function () use ($pageKey) {
            return PageImage::query()
                ->active()
                ->forPage($pageKey)
                ->get()
                ->mapWithKeys(function (PageImage $image) {
                    $disk = $image->disk ?: 'public';

                    $jpegUrl = $this->toPublicUrl($disk, $image->jpeg_path);
                    $webpUrl = $this->toPublicUrl($disk, $image->webp_path);

                    if (! $jpegUrl && $webpUrl) {
                        $jpegUrl = $webpUrl;
                    }

                    if (! $jpegUrl) {
                        return [];
                    }

                    return [
                        $image->slot_key => [
                            'webp_url' => $webpUrl,
                            'jpeg_url' => $jpegUrl,
                            'alt_text' => $image->alt_text ?: $image->title,
                        ],
                    ];
                })
                ->all();
        });

        return array_replace($fallbackMap, $payload);
    }

    public function currentVersion(string $pageKey): int
    {
        $versionKey = self::VERSION_PREFIX.$pageKey;

        return (int) Cache::rememberForever($versionKey, function () use ($pageKey) {
            if (! Schema::hasTable('page_images')) {
                return 1;
            }

            $version = PageImage::query()
                ->forPage($pageKey)
                ->max('cache_version');

            return max(1, (int) ($version ?? 1));
        });
    }

    /**
     * @param array<string, array{jpeg:string,webp?:string,alt?:string}> $fallbackSlots
     * @return array<string, array{webp_url:?string,jpeg_url:string,alt_text:string}>
     */
    private function buildFallbackMap(array $fallbackSlots): array
    {
        $mapped = [];

        foreach ($fallbackSlots as $slotKey => $slot) {
            $jpegSource = (string) $slot['jpeg'];
            $jpegUrl = str_starts_with($jpegSource, 'http://') || str_starts_with($jpegSource, 'https://')
                ? $jpegSource
                : asset(ltrim($jpegSource, '/'));

            $webpSource = (string) ($slot['webp'] ?? '');
            $webpUrl = null;

            if ($webpSource !== '') {
                $webpUrl = str_starts_with($webpSource, 'http://') || str_starts_with($webpSource, 'https://')
                    ? $webpSource
                    : asset(ltrim($webpSource, '/'));
            }

            $mapped[$slotKey] = [
                'webp_url' => $webpUrl,
                'jpeg_url' => $jpegUrl,
                'alt_text' => $slot['alt'] ?? 'Gambar Beranda',
            ];
        }

        return $mapped;
    }

    private function toPublicUrl(string $disk, ?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        if (str_starts_with($normalized, 'images/')) {
            return asset($normalized);
        }

        return Storage::disk($disk)->url($normalized);
    }
}
