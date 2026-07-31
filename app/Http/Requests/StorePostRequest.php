<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'  => ['required', 'string', 'max:255'],
            'body'   => ['required', 'string'],
            'userId' => ['required', 'integer'],
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
            'userId.required' => 'A valid user ID is required.',
            'userId.integer'  => 'The user ID must be a whole number.',
        ];
    }
}
