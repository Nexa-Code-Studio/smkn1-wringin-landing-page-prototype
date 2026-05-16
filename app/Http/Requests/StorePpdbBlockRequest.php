<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePpdbBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blockType = (string) $this->input('block_type');

        return array_merge([
            'block_type' => ['required', 'string', Rule::in(['text', 'image', 'file', 'link'])],
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
            'file' => [
                'label' => ['required', 'string', 'max:191'],
                'description' => ['nullable', 'string', 'max:255'],
                'button_text' => ['nullable', 'string', 'max:50'],
                'asset_file' => [$creating ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:20480'],
            ],
            'link' => [
                'label' => ['required', 'string', 'max:191'],
                'url' => ['required', 'url', 'max:2048'],
                'description' => ['nullable', 'string', 'max:255'],
                'style_variant' => ['nullable', 'string', Rule::in(['brand', 'outline'])],
            ],
            default => [],
        };
    }
}
