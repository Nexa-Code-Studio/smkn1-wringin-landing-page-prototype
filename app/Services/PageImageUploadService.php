<?php

namespace App\Services;

use App\Models\PageImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class PageImageUploadService
{
    private const PAGE_VERSION_KEY_PREFIX = 'page_images:version:';

    public function uploadFromDataUrl(array $payload): array
    {
        $pageKey = $payload['page_key'];
        $slotKey = $payload['slot_key'];
        $title = $payload['title'];
        $section = $payload['section'] ?? null;
        $altText = $payload['alt_text'] ?? null;
        $disk = $payload['disk'] ?? 'public';
        $updatedBy = $payload['updated_by'] ?? null;

        [$sourceMime, $binary] = $this->decodeDataUrl($payload['image_data']);
        $image = @imagecreatefromstring($binary);

        if (! $image) {
            throw new InvalidArgumentException('File gambar tidak valid atau tidak dapat diproses.');
        }

        $width = imagesx($image);
        $height = imagesy($image);

        $jpegQuality = 85;
        $webpQuality = 82;

        $jpegBinary = $this->encodeJpeg($image, $jpegQuality);
        $webpBinary = $this->encodeWebp($image, $webpQuality);

        imagedestroy($image);

        $basePath = "page-images/{$pageKey}/{$slotKey}";
        $jpegPath = "{$basePath}/current.jpg";
        $webpPath = "{$basePath}/current.webp";

        Storage::disk($disk)->put($jpegPath, $jpegBinary);
        Storage::disk($disk)->put($webpPath, $webpBinary);

        $now = now();

        $pageImage = PageImage::query()->updateOrCreate(
            [
                'page_key' => $pageKey,
                'slot_key' => $slotKey,
            ],
            [
                'section' => $section,
                'title' => $title,
                'alt_text' => $altText,
                'disk' => $disk,
                'jpeg_path' => $jpegPath,
                'webp_path' => $webpPath,
                'jpeg_width' => $width,
                'jpeg_height' => $height,
                'jpeg_bytes' => strlen($jpegBinary),
                'jpeg_quality' => $jpegQuality,
                'webp_width' => $width,
                'webp_height' => $height,
                'webp_bytes' => strlen($webpBinary),
                'webp_quality' => $webpQuality,
                'is_active' => true,
                'last_generated_at' => $now,
                'updated_by' => $updatedBy,
                'meta' => [
                    'source_mime' => $sourceMime,
                    'encoder' => 'gd',
                ],
            ]
        );

        $pageImage->increment('cache_version');
        $pageImage->refresh();

        $pageVersion = $this->bumpPageVersion($pageKey);

        return [
            'page_image' => $pageImage,
            'jpeg_url' => Storage::disk($disk)->url($jpegPath),
            'webp_url' => Storage::disk($disk)->url($webpPath),
            'page_version' => $pageVersion,
        ];
    }

    private function decodeDataUrl(string $dataUrl): array
    {
        if (! preg_match('/^data:(image\/[a-zA-Z0-9.+-]+);base64,/', $dataUrl, $matches)) {
            throw new InvalidArgumentException('Format gambar tidak valid.');
        }

        $mime = strtolower($matches[1]);
        $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

        if (! in_array($mime, $allowed, true)) {
            throw new InvalidArgumentException('Format gambar tidak didukung. Gunakan JPEG, PNG, atau WEBP.');
        }

        $base64 = substr($dataUrl, strpos($dataUrl, ',') + 1);
        $binary = base64_decode($base64, true);

        if ($binary === false || $binary === '') {
            throw new InvalidArgumentException('Gagal membaca data gambar.');
        }

        if (strlen($binary) > 12 * 1024 * 1024) {
            throw new InvalidArgumentException('Ukuran gambar terlalu besar. Maksimal 12MB.');
        }

        return [$mime, $binary];
    }

    private function encodeJpeg(\GdImage $image, int $quality): string
    {
        ob_start();
        imagejpeg($image, null, $quality);
        $binary = ob_get_clean();

        if ($binary === false || $binary === '') {
            throw new InvalidArgumentException('Gagal membuat varian JPEG.');
        }

        return $binary;
    }

    private function encodeWebp(\GdImage $image, int $quality): string
    {
        ob_start();
        imagewebp($image, null, $quality);
        $binary = ob_get_clean();

        if ($binary === false || $binary === '') {
            throw new InvalidArgumentException('Gagal membuat varian WEBP.');
        }

        return $binary;
    }

    private function bumpPageVersion(string $pageKey): int
    {
        $versionKey = self::PAGE_VERSION_KEY_PREFIX.$pageKey;

        if (! Cache::has($versionKey)) {
            Cache::forever($versionKey, 1);
        }

        return (int) Cache::increment($versionKey);
    }
}
