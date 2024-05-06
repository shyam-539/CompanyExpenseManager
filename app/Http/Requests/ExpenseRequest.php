<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0',
            'images' => 'array|max:5', // Array of images with maximum 5 images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:2048' // Individual image rules

        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least :min.',
            'images.array' => 'The images must be an array.',
            'images.max' => 'You can upload a maximum of :max images.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The image must be a file of type: :values.',
            'images.*.max' => 'The image may not be greater than :max kilobytes.'
        ];
    }
}
