<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTechnologyServiceCategoryRequest extends FormRequest
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
            'code' => 'required|string|max:3',
            'name' => 'required|string|max:100|' . Rule::unique('technology_service_categories', 'name')->ignore($this->technologyServiceCategory?->id),
            'description' => 'required|string|max:2000',
        ];
    }

    public function attributes(): array
    {
        return [
            'code'        => 'código de la categoría',
            'name'        => 'nombre',
            'description' => 'descripción',
        ];
    }
}
