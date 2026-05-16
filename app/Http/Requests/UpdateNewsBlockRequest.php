<?php

namespace App\Http\Requests;

use App\Models\NewsArticleBlock;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeBlock = $this->route('block');
        $block = $routeBlock instanceof NewsArticleBlock
            ? $routeBlock
            : NewsArticleBlock::query()->find((int) $routeBlock);

        return match ((string) $block?->block_type) {
            'text' => [
                'heading' => ['nullable', 'string', 'max:191'],
                'body' => ['required', 'string'],
            ],
            'image' => [
                'caption' => ['nullable', 'string', 'max:255'],
                'alt_text' => ['nullable', 'string', 'max:255'],
                'asset_file' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:12288'],
            ],
            'image_showcase' => [
                'alt_text' => ['nullable', 'string', 'max:255'],
                'asset_files' => ['nullable', 'array', 'min:1'],
                'asset_files.*' => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:12288'],
            ],
            'highlight_text' => [
                'text' => ['required', 'string', 'max:1000'],
            ],
            default => [],
        };
    }
}
