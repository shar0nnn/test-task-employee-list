<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CreateEmployeeRequest extends FormRequest
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
        dd($this->request->all());
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:256'],
//            'hired_at' => ['required', 'date'],
            'phone' => ['required', 'string', 'size:13', 'unique:employees,phone'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'position' => ['required', 'exists:positions,id'],
            'salary' => ['required', 'numeric', 'min:0', 'max:500000'],
//            'manager' => ['required', 'string', 'exists:managers,name'],
            'photo' => File::image()
                ->types(['jpg', 'png'])
                ->max(5 * 1024)
                ->dimensions(Rule::dimensions()->minHeight(300)->minWidth(300)),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => preg_replace('/[^\d+]/', '', $this->phone)
        ]);
    }
}
