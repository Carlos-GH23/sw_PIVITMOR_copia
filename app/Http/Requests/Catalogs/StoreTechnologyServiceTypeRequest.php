<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnologyServiceTypeRequest extends FormRequest
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
            'code'        => 'required|max:10|string',
            'category_id' => 'required|exists:technology_service_categories,id',
            'name'        => 'required|unique:technology_service_types,name,NULL,id,deleted_at,NULL|max:100|string',
            'description' => 'required|max:2000|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'code'        => 'código del tipo de servicio',
            'category_id' => 'categoría del tipo de servicio',
            'name'        => 'nombre',
            'description' => 'descripción',
        ];
    }
}
