<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchBlogRequest extends FormRequest
{
    #[Override]
    public function authorize(): bool { return true; }

    #[Override]
    public function rules(): array
    {
        return ['search_query' => ['required', 'string', 'min:2']];
    }
}
