<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

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
        return [
            'fullName' => ['required', 'string', 'min:2', 'max:256'],
            'hiredAt' => ['required', 'date'],
            'phone' => ['required', 'string', 'size:13', 'unique:employees,phone'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'position' => ['required', 'exists:positions,id'],
            'salary' => ['required', 'numeric', 'min:0', 'max:500000', 'regex:/^\d+(\.\d{2})?$/'],
            'manager.id' => ['required', 'exists:employees,id'],
            'manager.name' => 'required',
            'photo' => ['nullable', File::image()
                ->types(['jpg', 'png'])
                ->max(5 * 1024)
                ->dimensions(Rule::dimensions()->minHeight(300)->minWidth(300))],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => preg_replace('/[^\d+]/', '', $this->phone),
            'hiredAt' => substr($this->hiredAt, 0, 10)
        ]);
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $manager = Employee::query()->where('id', $this->input('manager.id'))->first();
                if ($manager && $manager->full_name !== $this->input('manager.name')) {
                    $validator->errors()->add('manager.name', 'Такого керівника не існує');
                }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'fullName.required' => 'Потрібно ввести ім\'я',
            'fullName.min' => 'Ім\'я" повинно містити не менше 2 символів',
            'fullName.max' => 'Ім\'я" не може містити більше 256 символів',

            'hiredAt.required' => 'Потрібно вибрати дату працевлаштування',

            'phone.required' => 'Потрібно ввести номер телефону',
            'phone.size' => 'Невірна кількість символів в номері телефону',
            'phone.unique' => 'Цей номер телефону вже використовується',

            'email.required' => 'Потрібно ввести електронну пошту',
            'email.email' => 'Потрібно ввести коректну адресу електронної пошти',
            'email.unique' => 'Ця електронна пошта вже використовується',

            'position.required' => 'Потрібно вибрати посаду',
            'position.exists' => 'Такої посади не існує',

            'salary.required' => 'Потрібно вказати зарплату',
            'salary.numeric' => 'Зарплата повинна бути числовим значенням',
            'salary.regex' => 'Дозволяється тільки два знаки після коми',
            'salary.min' => 'Зарплата не може бути менше 0',
            'salary.max' => 'Зарплата не може бути більше 500000',

            'manager.name.required' => 'Потрібно ввести ім\'я керівника',
            'manager.id.exists' => 'Такого керівника не існує',

            'photo.mimes' => 'Файл має бути зображенням, формат: jpg, png',
            'photo.max' => 'Максимальний розмір зображення: 5 МБ',
            'photo.dimensions' => 'Мінімальний розмір фото - 300x300 пікселів',
        ];
    }
}
