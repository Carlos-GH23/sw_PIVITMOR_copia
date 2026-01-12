<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFacilityTypeRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('facility_types', 'name')->ignore($this->route('facilityType')),
            ],
            'description' => 'nullable|max:2000|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nombre',
            'description' => 'descripción',
        ];
    }
}
