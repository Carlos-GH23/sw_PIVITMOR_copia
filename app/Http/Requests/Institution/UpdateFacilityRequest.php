<?php

namespace App\Http\Requests\Institution;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\PhotoRules;
use App\Http\Requests\Traits\FileValidationRules;
use Illuminate\Validation\Rule;

class UpdateFacilityRequest extends FormRequest
{
    use PhotoRules;
    use FileValidationRules;
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
        return array_merge(
            $this->photoRules(),
            $this->filesRules(),
                [
                'name'        => [
                    'required',
                    'string',
                    'max:250',
                    Rule::unique('facilities', 'name')->ignore($this->route('facility')->id),
                ],
                'description' => 'nullable|max:2000|string',
                'facility_type_id'        => 'required|exists:facility_types,id',
                'department_id'  => 'required|exists:departments,id',
                'is_active'   => 'nullable|boolean',
            ]
        );
    }

    public function attributes(): array
    {
        return array_merge( 
            $this->photoAttributes(),
            $this->filesAttributes(),
                [
                'name'        => 'nombre',
                'description' => 'descripción',
                'facility_type_id'        => 'tipo',
                'department_id'  => 'departamento',
                'is_active'   => 'activo',
            ]
        );
    }
}
