<?php

namespace App\Services;

use App\Models\PageAsset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class PageAssetUploadService
{
    public function storeImage(string $pageKey, UploadedFile $file, ?int $updatedBy = null): PageAsset
    {
        $binary = $file->get();
        $image = @imagecreatefromstring($binary);

        if (! $image) {
            throw new InvalidArgumentException('File gambar tidak valid atau tidak dapat diproses.');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $uuid = (string) Str::uuid();
        $basePath = "page-assets/{$pageKey}/images/{$uuid}";
        $jpegPath = "{$basePath}/current.jpg";
        $webpPath = "{$basePath}/current.webp";

        $jpegBinary = $this->encodeJpeg($image, 85);
        $webpBinary = $this->encodeWebp($image, 82);

        imagedestroy($image);

        Storage::disk('public')->put($jpegPath, $jpegBinary);
        Storage::disk('public')->put($webpPath, $webpBinary);

        return PageAsset::query()->create([
            'page_key' => $pageKey,
            'asset_type' => 'image',
            'disk' => 'public',
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'jpeg_path' => $jpegPath,
            'webp_path' => $webpPath,
            'width' => $width,
            'height' => $height,
            'updated_by' => $updatedBy,
            'meta' => [
                'source_extension' => strtolower($file->getClientOriginalExtension()),
                'encoder' => 'gd',
            ],
        ]);
    }

    public function storeFile(string $pageKey, UploadedFile $file, ?int $updatedBy = null): PageAsset
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $uuid = (string) Str::uuid();
        $path = $file->storeAs("page-assets/{$pageKey}/files/{$uuid}", 'original.'.$extension, 'public');

        return PageAsset::query()->create([
            'page_key' => $pageKey,
            'asset_type' => 'file',
            'disk' => 'public',
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'original_path' => $path,
            'updated_by' => $updatedBy,
            'meta' => [
                'source_extension' => $extension,
            ],
        ]);
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
}
