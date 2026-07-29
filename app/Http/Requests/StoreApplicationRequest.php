<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'address' => ['required','ip'],
            'port' => ['required','integer','between:1,65535'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Application name is required',
            'name.string' => 'Name should be a string',
            'name.max' => 'Maximum 255 characters',
            'address.required' => 'Address is required',
            'address.ip' => 'Should be an ip',
            'port.required' => 'Port is required',
            'port.integer' => 'Port should be an integer',
            'port.between' => 'Port should be between 1 and 65535',
        ];
    }
}
