<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
            'positionName' => ['required', 'string', 'max:256'],
        ];
    }

    public function messages(): array
    {
        return [
            'positionName.required' => 'Необхідно вказати назву посади',
            'positionName.max' => 'Максимальний розмір - 256 символів',
        ];
    }
}
