<?php

namespace App\Http\Requests\Academic;

use App\Http\Requests\Traits\FileValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicBackgroundRequest extends FormRequest
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
            [
                'academic_title' => 'required|string|max:255',
                'institution_name' => 'required|string|max:255',
                'academic_degree_id' => 'required|exists:academic_degrees,id',
                'knowledge_area_id' => 'required|exists:knowledge_areas,id',
                'country_id' => 'required|exists:countries,id',
                'degree_obtained_at' => 'required|date|before_or_equal:today',
                'certificate_number' => 'required|integer',
            ],
            $this->filesRules()
        );
    }

    public function attributes(): array
    {
        return array_merge(
            $this->filesAttributes(),
            [
                'academic_title' => 'título académico',
                'institution_name' => 'institución que lo otorga',
                'academic_degree_id' => 'grado académico',
                'knowledge_area_id' => 'área de conocimiento',
                'country_id' => 'país',
                'degree_obtained_at' => 'fecha de obtención del grado',
                'certificate_number' => 'número de cédula profesional',
            ]
        );
    }
    /**
     * Get custom validation messages for the request.
     */
    public function messages(): array
    {
        return [
            'degree_obtained_at.required' => 'El campo :attribute es obligatorio.',
            'degree_obtained_at.date' => 'El campo :attribute debe ser una fecha válida.',
            'degree_obtained_at.before_or_equal' => 'El campo :attribute debe ser anterior o igual a hoy.'
        ];
    }
}
