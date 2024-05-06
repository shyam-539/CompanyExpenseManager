<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|regex:/^[a-zA-Z\s]+$/',
            'tax_percentage' => 'required|numeric|between:0,100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.min' => 'The category name must be at least 2 characters.',
            'name.regex' => 'The category name must contain only alphabetic characters.',
            'tax_percentage.required' => 'The tax percentage is required.',
            'tax_percentage.numeric' => 'The tax percentage must be a numeric value.',
            'tax_percentage.between' => 'The tax percentage must be between 0 and 100.',
        ];
    }
}
