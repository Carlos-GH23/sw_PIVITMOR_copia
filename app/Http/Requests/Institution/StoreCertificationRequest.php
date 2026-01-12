<?php

namespace App\Http\Requests\Institution;
use App\Http\Requests\Traits\FileValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreCertificationRequest extends FormRequest
{
    use FileValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'certification_type_id' => 'required|integer|exists:certification_types,id',
            'certifying_entity' => 'required|string|max:255',
            'resource_type_id' => 'required|integer|exists:resource_types,id',
            'department_id' => 'required|integer|exists:departments,id',
            'certified_resource_id' => 'required|integer',
        ], $this->filesRules());
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
                'certified_resource_id' => 'recurso certificado',
            ]
        );
    }
}