<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blockType = (string) $this->input('block_type');

        return array_merge([
            'block_type' => ['required', 'string', Rule::in(['text', 'image', 'image_showcase', 'highlight_text'])],
        ], $this->rulesForType($blockType, true));
    }

    private function rulesForType(string $blockType, bool $creating): array
    {
        return match ($blockType) {
            'text' => [
                'heading' => ['nullable', 'string', 'max:191'],
                'body' => ['required', 'string'],
            ],
            'image' => [
                'caption' => ['nullable', 'string', 'max:255'],
                'alt_text' => ['nullable', 'string', 'max:255'],
                'asset_file' => [$creating ? 'required' : 'nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:12288'],
            ],
            'image_showcase' => [
                'alt_text' => ['nullable', 'string', 'max:255'],
                'asset_files' => [$creating ? 'required' : 'nullable', 'array', 'min:1'],
                'asset_files.*' => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:12288'],
            ],
            'highlight_text' => [
                'text' => ['required', 'string', 'max:1000'],
            ],
            default => [],
        };
    }
}
