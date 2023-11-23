<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePursheseRequest extends FormRequest
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
            'client_email' => ['required', 'string', 'max:100', 'exists:users,email'],
            'plant_name' => ['required', 'string', 'max:200', 'exists:plants,name'],
            'freight_state' => ['required', 'string', 'exists:freights,state'],
            'status' => ['required', 'string', 'max:16'],
            'mount' => ['required', 'numeric'],
        ];
    }
}
