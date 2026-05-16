<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsFeaturedArticlesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slots' => ['required', 'array', 'size:4'],
            'slots.*' => ['nullable', 'integer', 'exists:news_articles,id'],
        ];
    }
}
