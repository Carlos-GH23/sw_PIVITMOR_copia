<?php

namespace App\Http\Requests\Institution;
use App\Http\Requests\Traits\FileValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCertificationRequest extends FormRequest
{
    use FileValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->filesRules(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('institution_certifications', 'name')->ignore($this->route('certification')->id),
                ],
                'description'           => 'required|string|max:2000',
                'certification_type_id' => 'required|integer|exists:certification_types,id',
                'certifying_entity'     => 'required|string|max:255',
                'resource_type_id'      => 'required|integer|exists:resource_types,id',
                'department_id'         => 'required|integer|exists:departments,id',
                'certified_resource_id'           => 'required|integer',
            ]
        );
    }

    public function attributes(): array
    {
        return array_merge(
            $this->filesAttributes(),
            [
                'name'                  => 'nombre',
                'description'           => 'descripción',
                'certification_type_id' => 'tipo de certificación',
                'certifying_entity'     => 'entidad certificadora',
                'resource_type_id'      => 'tipo de recurso',
                'department_id'         => 'departamento',
                'certified_resource_id'           => 'recurso certificado',
            ]
        );
    }
}