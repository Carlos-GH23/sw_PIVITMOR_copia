<?php

namespace App\Http\Requests\Institution;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'is_active'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'El nombre es requerido.',
            'name.min'             => 'El nombre debe tener al menos 3 caracteres.',
            'name.max'             => 'El nombre no puede exceder 255 caracteres.',
            'description.required' => 'La descripción es requerida.',
            'description.min'      => 'La descripción debe tener al menos 10 caracteres.',
            'description.max'      => 'La descripción no puede exceder 2000 caracteres.',
        ];
    }
}
