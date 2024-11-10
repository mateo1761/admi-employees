<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:deparments,name'
        ];
    }

    /**
     * Custom messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del departamento es obligatorio.',
            'name.string' => 'El nombre del departamento debe ser una cadena de texto.',
            'name.max' => 'El nombre del departamento no debe exceder los 100 caracteres.',
            'name.unique' => 'El nombre del departamento ya está en uso.',
        ];
    }
}
