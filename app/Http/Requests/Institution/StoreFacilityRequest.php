<?php

namespace App\Http\Requests\Institution;

use App\Http\Requests\Traits\FileValidationRules;
use App\Http\Requests\Traits\PhotoRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreFacilityRequest extends FormRequest
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
                'name'        => 'required|unique:facilities,name,NULL,id,deleted_at,NULL|max:100|string',
                'description' => 'nullable|max:2000|string',
                'facility_type_id'        => 'nullable|exists:facility_types,id',
                'department_id'  => 'nullable|exists:departments,id',
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
                'equipment' => 'equipamiento',
                'is_active'   => 'activo',
            ]
        );
    }
}
