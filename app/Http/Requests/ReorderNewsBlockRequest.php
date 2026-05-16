<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReorderNewsBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'block_ids' => ['required', 'array', 'min:1'],
            'block_ids.*' => ['required', 'integer', 'distinct'],
        ];
    }
}
