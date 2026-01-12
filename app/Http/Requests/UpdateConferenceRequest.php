<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;

class UpdateConferenceRequest extends FormRequest
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
        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'speaker_bio' => ['nullable', 'string', 'max:2000'],
            'audience_types' => ['required_if:conference_status_id,2', 'array', 'min:1'],
            'audience_types.*' => ['integer', 'min:1', 'max:4'],
            'modality' => ['required_if:conference_status_id,2', 'string', 'in:Presencial,Virtual,Híbrido'],
            'language_id' => ['required_if:conference_status_id,2', 'integer', 'exists:languages,id'],
            'start_date' => ['required_if:conference_status_id,2', 'date'],
            'end_date' => ['required_if:conference_status_id,2', 'date', 'after_or_equal:start_date'],
            'technical_requirements' => ['nullable', 'string', 'max:2000'],
            'department_id' => ['required_if:conference_status_id,2', 'integer', 'exists:departments,id'],
            'academics' => ['required', 'array', 'min:1'],
            'academics.*' => ['integer', 'exists:academics,id'],
            'oecd_sectors' => ['nullable', 'array', 'min:1'],
            'oecd_sectors.*' => ['integer', 'exists:oecd_sectors,id'],
            'economic_sectors' => ['nullable', 'array', 'min:1'],
            'economic_sectors.*' => ['integer', 'exists:economic_sectors,id'],
            'keywords' => ['required_if:conference_status_id,2', 'array', 'min:1', 'max:5'],
            'keywords.*.name' => ['required', 'string', 'max:50'],
            'conference_status_id' => ['required', 'integer', 'exists:conference_statuses,id'],
        ], $this->filesRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'title' => 'título',
            'description' => 'descripción',
            'speaker_bio' => 'biografía del ponente',
            'audience_types' => 'tipos de audiencia',
            'audience_types.*' => 'tipo de audiencia',
            'modality' => 'modalidad',
            'language_id' => 'idioma',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha de término',
            'technical_requirements' => 'requerimientos técnicos',
            'department_id' => 'departamento',
            'academics' => 'ponentes',
            'academics.*' => 'ponentes',
            'oecd_sectors' => 'disciplinas científicas y tecnológicas',
            'oecd_sectors.*' => 'disciplina científica y tecnológica',
            'economic_sectors' => 'sectores económicos',
            'economic_sectors.*' => 'sector económico',
            'keywords' => 'palabras clave',
            'keywords.*.name' => 'palabra clave',
        ], $this->filesAttributes());
    }

    public function messages()
    {
        return [
            'audience_types.required_if' => 'El campo :attribute es obligatorio.',
            'modality.required_if' => 'El campo :attribute es obligatorio.',
            'language_id.required_if' => 'El campo :attribute es obligatorio.',
            'start_date.required_if' => 'El campo :attribute es obligatorio.',
            'end_date.required_if' => 'El campo :attribute es obligatorio.',
            'department_id.required_if' => 'El campo :attribute es obligatorio.',
            'academics.required_if' => 'El campo :attribute es obligatorio.',
            'keywords.required_if' => 'El campo :attribute es obligatorio.'
        ];
    }
}
