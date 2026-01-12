<?php

namespace App\Http\Requests\Institution;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\Traits\PhotoRules;
use App\Http\Requests\Traits\FileValidationRules;

class UpdateEquipmentRequest extends FormRequest
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
                    Rule::unique('facility_equipments', 'name')->ignore($this->route('equipment')->id),
                ],
                'description' => 'nullable|max:2000|string',
                'equipment_type_id'        => 'required|exists:equipment_types,id',
                'responsible_id' => 'required|exists:academics,id',
                'facility_id'  => 'required|exists:facilities,id',
                'status'   => 'nullable|boolean',
                'department_id' => 'required|exists:departments,id',
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
                'equipment_type_id'        => 'tipo de equipamiento',
                'facility_id'  => 'instalación especializada',
                'status'   => 'estado',
                'department_id' => 'departamento',
            ]
        );
    }
}
