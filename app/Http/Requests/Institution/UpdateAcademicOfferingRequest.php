<?php

namespace App\Http\Requests\Institution;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;
use Illuminate\Validation\Rule;

class UpdateAcademicOfferingRequest extends FormRequest
{
    use FileValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            [
                'name'                      => ['required', 'string', 'max:255'],
                'description'               => ['required', 'string', 'max:2000'],
                'objective'                 => ['required', 'string', 'max:2000'],
                'graduate_profile'          => ['required', 'string', 'max:2000'],
                'educational_level_id'      => ['required', 'integer', 'exists:educational_levels,id'],
                'study_mode_id'             => ['required', 'integer', 'exists:study_modes,id'],
                'department_id'             => ['required', 'integer', 'exists:departments,id'],
                'revoe'                     => ['required', 'string', 'max:100'],
                'website'                   => ['nullable', 'url'],
                'semester_cost'             => ['nullable', 'numeric', 'min:0'],
                'duration_months'           => ['nullable', 'integer', 'min:1', 'max:300'],
                'keywords'                  => ['required', 'array'],
                'keywords.*.name'           => ['required', 'string', 'max:50'],

                'oecd_sectors'              => ['nullable', 'array'],
                'oecd_sectors.*'            => ['integer', 'exists:oecd_sectors,id'],
                'economic_sectors'          => ['nullable', 'array'],
                'economic_sectors.*'        => ['integer', 'exists:economic_sectors,id'],
            ],
            $this->filesRules(5, 10240),
            $this->accreditationRules()
        );
    }

    public function attributes(): array
    {
        return array_merge(
            [
                'name'                      => 'nombre',
                'description'               => 'descripcion',
                'objective'                 => 'objetivo',
                'graduate_profile'          => 'perfil de egreso',
                'educational_level_id'      => 'nivel educativo',
                'study_mode_id'             => 'modalidad de estudio',
                'department_id'             => 'departamento',
                'revoe'                     => 'REVOE',
                'website'                   => 'website',
                'semester_cost'             => 'costo del semestre',
                'duration_months'           => 'duración en meses',
                'keywords'                  => 'palabras clave',
                'snp_start_date'            => 'fecha de inicio SNP',
                'snp_end_date'              => 'fecha de finalización SNP',
                'oecd_sectors'              => 'disciplinas OCDE',
                'economic_sectors'          => 'sectores económicos',

                'has_copaes_accreditation'  => 'acreditación COPAES',
                'copaes_accreditation_id'   => 'tipo COPAES',
                'copaes_expiry_date'        => 'fecha de expiración',

                'has_ciees_accreditation'   => 'acreditación CIEES',
                'ciees_accreditation_id'    => 'tipo CIEES',
                'ciees_level'               => 'nivel CIEES',
                'ciees_expiry_date'         => 'fecha de expiración',

                'fimpes_accreditation_id'   => 'acreditación FIMPE',
            ],
            $this->filesAttributes()
        );
    }

    public function messages(): array
    {
        return [
            'copaes_accreditation_id.required_if'   => 'El :attribute es requerido cuando se tiene una acreditación COPAES.',
            'copaes_expiry_date.required_if'        => 'La :attribute es requerida cuando se tiene una acreditación COPAES.',
            'ciees_level.required_if'               => 'El :attribute es requerido cuando se tiene una acreditación CIEES.',
            'ciees_expiry_date.required_if'         => 'La :attribute es requerida cuando se tiene una acreditación CIEES.',

            'snp_start_date.required_if'            => 'La :attribute es requerida si el programa es reconocido por el SNP.',
            'snp_end_date.required_if'              => 'La :attribute es obligatoria cuando el programa es reconocido por el SNP.',
            'snp_end_date.after_or_equal'           => 'La :attribute debe ser posterior o igual a la fecha de inicio.',
        ];
    }

    private function accreditationRules(): array
    {
        return [
            'has_copaes_accreditation'  => ['required', 'boolean'],
            'copaes_accreditation_id'   => ['nullable', 'integer', 'required_if:has_copaes_accreditation,true', 'exists:copaes_accreditations,id'],
            'copaes_expiry_date'        => ['nullable', 'date', 'required_if:has_copaes_accreditation,true',],

            'has_ciees_accreditation'   => ['required', 'boolean'],
            'ciees_accreditation_id'    => ['nullable', 'integer', 'required_if:has_ciees_accreditation,true', 'exists:ciees_accreditations,id'],
            'ciees_level'               => ['nullable', 'integer', 'required_if:has_ciees_accreditation,true'],
            'ciees_expiry_date'         => ['nullable', 'date', 'required_if:has_ciees_accreditation,true'],

            'fimpes_accreditation_id'   => ['nullable', 'integer', 'exists:fimpes_accreditations,id'],

            'has_snp'                   => ['required', 'boolean'],
            'snp_start_date'            => ['nullable', 'date', 'required_if:has_snp,true'],
            'snp_end_date'              => ['nullable', 'date', 'required_if:has_snp,true', 'after_or_equal:snp_start_date'],
        ];
    }
}
