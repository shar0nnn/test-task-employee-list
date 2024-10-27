<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class UpdateEmployeeRequest extends EmployeeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['phone'][] = Rule::unique('employees', 'phone')->ignore($this->input('id'));
        $rules['email'][] = Rule::unique('employees', 'email')->ignore($this->input('id'));
        $rules['rank'] = ['required', 'in:1,2,3,4,5'];
        $rules['manager.id'][] = [Rule::requiredIf(fn() => $this->rank < 5), 'exists:employees,id'];
        $rules['manager.name'][] = Rule::requiredIf(fn() => $this->rank < 5);

        return $rules;
    }
}
