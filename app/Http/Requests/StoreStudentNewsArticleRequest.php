<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentNewsArticleRequest extends FormRequest
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
            'cover_alt_text' => ['nullable', 'string', 'max:255'],
            'cover_file' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:12288'],
            'tags' => ['nullable', 'string'],
        ];
    }
}
