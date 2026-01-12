<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;
use App\Http\Requests\Traits\PhotoRules;

class StoreCapabilityRequest extends FormRequest
{
    use FileValidationRules;
    use PhotoRules;
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
        return array_merge([
            'title' => ['required', 'string', 'max:400'],
            'technical_description' => ['required_if:capability_status_id,2', 'nullable', 'string', 'max:2000'],
            'problem_statement' => ['required_if:capability_status_id,2', 'nullable', 'string', 'max:2000'],
            'potential_applications' => ['required_if:capability_status_id,2', 'nullable', 'string', 'max:2000'],
            'start_date' => ['date', 'nullable'],
            'end_date' => ['date', 'nullable', 'after_or_equal:start_date'],
            'capability_status_id' => ['required', 'integer', 'exists:capability_statuses,id'],
            'intellectual_property_id' => ['nullable', 'integer', 'exists:intellectual_properties,id'],
            'technology_level_id' => ['nullable', 'integer', 'exists:technology_levels,id'],

            'keywords' => ['required_if:capability_status_id,2', 'nullable', 'array', 'max:5'],
            'keywords.*.name' => ['required', 'string', 'max:50'],

            'oecd_sectors' => ['array', 'nullable'],
            'oecd_sectors.*' => ['integer', 'exists:oecd_sectors,id'],

            'knowledge_areas' => ['array', 'nullable'],
            'knowledge_areas.*' => ['integer', 'exists:knowledge_areas,id'],

            'economic_sectors' => ['array', 'nullable'],
            'economic_sectors.*' => ['integer', 'exists:economic_sectors,id'],

            'academics' => ['array', 'nullable'],
            'academics.*' => ['integer', 'exists:academics,id'],
        ], $this->filesRules(), $this->photoRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'title' => 'título',
            'technical_description' => 'descripción técnica',
            'problem_statement' => 'problema',
            'potential_applications' => 'aplicaciones potenciales',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha de cierre',
            // 'capability_status_id' => 'estado',
            'keywords' => 'palabras clave',
            'keywords.*.name' => 'palabra clave',
        ], $this->filesAttributes(), $this->photoAttributes());
    }

    public function messages()
    {
        return [
            'technical_description.required_if' => 'El campo :attribute es obligatorio.',
            'problem_statement.required_if' => 'El campo :attribute es obligatorio.',
            'potential_applications.required_if' => 'El campo :attribute es obligatorio.',
            'keywords.required_if' => 'El campo :attribute es obligatorio.'
        ];
    }
}
