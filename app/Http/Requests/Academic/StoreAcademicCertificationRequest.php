<?php

namespace App\Http\Requests\Academic;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;

class StoreAcademicCertificationRequest extends FormRequest
{
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
            $this->filesRules(),
            [
                'name'                     => 'required|string|max:250|unique:academic_certifications,name',
                'description'              => 'required|string|max:2000',
                'certification_level_id'   => 'required|exists:certification_levels,id',
                'certifying_entity'        => 'required|string|max:100',
                'accreditation_entity_id'  => 'required|exists:accreditation_entities,id',
                'country_id'               => 'required|exists:countries,id',
                'status_id'                => 'required|exists:academic_certification_statuses,id',
                'issue_date'              => 'required|date',
                'expiry_date'              => 'required|date|after:issued_date',
                'validity_duration'        => 'required|integer|min:0',
                'is_active'                => 'nullable|boolean',
            ]
        );
    }

    public function attributes(): array
    {
        return array_merge(
            $this->filesAttributes(),
            [
                'name'                     => 'nombre',
                'description'              => 'descripción',
                'certification_level_id'   => 'nivel de certificación',
                'certifying_entity'        => 'entidad certificadora',
                'accreditation_entity_id'  => 'entidad de acreditación',
                'country_id'               => 'país',
                'status_id'                => 'estado de la certificación',
                'issue_date'              => 'fecha de emisión',
                'expiry_date'              => 'fecha de expiración',
                'validity_duration'        => 'duración de la validez',
                'is_active'                => 'activo',
            ]
        );
    }
}
