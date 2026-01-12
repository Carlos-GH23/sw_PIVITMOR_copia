<?php

namespace App\Http\Requests\Academic;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;

class UpdateAcademicCertificationRequest extends FormRequest
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
                'name'        => [
                    'required',
                    'string',
                    'max:250',
                    Rule::unique('academic_certifications', 'name')->ignore($this->route('certification')->id),
                ],
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
}
