<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:220'],
            'excerpt' => ['nullable', 'string'],
            'author_name' => ['nullable', 'string', 'max:120'],
            'cover_alt_text' => ['nullable', 'string', 'max:255'],
            'cover_file' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:12288'],
            'workflow_status' => ['required', 'string', Rule::in(['draft', 'pending_review', 'published', 'rejected'])],
            'published_at' => ['nullable', 'date'],
            'rejection_note' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
        ];
    }
}
