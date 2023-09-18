<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string','min:3', 'max:100', Rule::unique('plants')->ignore($this->plant)],
            'description' => ['required', 'string', 'min:10', 'max:200'],
            'value' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id'],
            'path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'value.numeric' => 'The value field must be a number.',
            'path.required' => 'The path (image) field is required.',
            'path.image' => 'The path field must be a valid image.',
            'path.mimes' => 'The path field must be an image in jpeg, png, jpg, or gif format.',
            'path.max' => 'The path field should not exceed 2 MB in size.',
        ];
    }
}
