<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body'  => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Please enter a title.',
            'title.string'    => 'The title must be valid text.',
            'title.max'       => 'The title cannot exceed 255 characters.',
            'body.required'   => 'Please enter the content body.',
            'body.string'     => 'The body must be valid text.',
        ];
    }
}