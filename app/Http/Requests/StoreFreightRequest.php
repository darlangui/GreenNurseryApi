<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFreightRequest extends FormRequest
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
            'state' => ['required', 'string', 'min:1', 'max:100', Rule::unique('freights')->ignore($this->freight)],
            'cep' => ['required', 'string', 'min:8', 'max:9'],
            'value' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'value.numeric' => 'The value field must be a number.',
        ];
    }
}
