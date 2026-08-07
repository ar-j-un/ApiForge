<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    #[Override]
    public function authorize(): bool { return true; }

    #[Override]
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'author_name' => ['required', 'string', 'max:255'],
            'is_published' => ['boolean'],
        ];
    }
}
