<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Validator;

class CreateEmployeeRequest extends EmployeeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['phone'][] = 'unique:employees,phone';
        $rules['email'][] = 'unique:employees,email';
        $rules['manager.id'][] = ['required', 'exists:employees,id'];
        $rules['manager.name'][] = 'required';

        return $rules;
    }
}
