<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;
use App\Http\Requests\Traits\PhotoRules;


class StoreTechnologyServiceRequest extends FormRequest
{
    use PhotoRules;
    use FileValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('technologyServices.evaluations.store')) {
            return in_array($this->input('technology_service_status_id'), [1, 3]);
        }

        return in_array($this->input('technology_service_status_id'), [1, 2]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $statusBasedRule = ((int)$this->input('technology_service_status_id') === 2 || (int)$this->input('technology_service_status_id') === 3)
            ? 'required' : 'nullable';
        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'technical_description' => ['nullable', 'max:2000', 'string'],
            'technology_service_status_id' => ['required', 'integer', 'exists:technology_service_statuses,id'],
            'technology_service_type_id' => [$statusBasedRule, 'exists:technology_service_types,id'],
            'technology_service_category_id' => [$statusBasedRule, 'exists:technology_service_categories,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'start_date' => [$statusBasedRule, 'nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'oecd_sectors' => ['nullable', 'array'],
            'oecd_sectors.*' => ['exists:oecd_sectors,id'],
            'economic_sectors' => ['nullable', 'array'],
            'economic_sectors.*' => ['exists:economic_sectors,id'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
            'equipments' => ['nullable', 'array'],
            'equipments.*' => ['exists:facility_equipments,id'],
            'keywords' => ['nullable', 'array', 'max:5'],
            'keywords.*.name' => ['required_with:keywords', 'string', 'max:50'],
            'academics' => ['nullable', 'array'],
            'academics.*' => ['exists:academics,id'],
        ], $this->filesRules(), $this->photoRules());
    }

    public function attributes(): array
    {
        return array_merge(
            $this->photoAttributes(),
            $this->filesAttributes(),
            [
                'title' => 'título',
                'description' => 'descripción',
                'technology_service_status_id' => 'estatus del servicio',
                'technology_service_type_id' => 'tipo de servicio',
                'technology_service_category_id' => 'categoría de servicio',
                'department_id' => 'departamento',
                'start_date' => 'fecha de inicio',
                'end_date' => 'fecha de fin',
                'is_active' => 'activo',
                'oecd_sectors' => 'sectores OCDE',
                'oecd_sectors.*' => 'sector OCDE',
                'economic_sectors' => 'sectores económicos',
                'economic_sectors.*' => 'sector económico',
                'facilities' => 'instalaciones especializadas',
                'facilities.*' => 'instalación especializada',
                'equipments' => 'equipamientos',
                'equipments.*' => 'equipamiento',
                'keywords' => 'palabras clave',
                'keywords.*' => 'palabra clave',
                'academics' => 'académicos',
                'academics.*' => 'académico',
            ]
        );
    }

    public function messages()
    {
        return [
            'title.required_if' => 'El campo :attribute es obligatorio.',
            'description.required_if' => 'El campo :attribute es obligatorio.',
            'technology_service_type_id.required_if' => 'El campo :attribute es obligatorio.',
            'technology_service_category_id.required_if' => 'El campo :attribute es obligatorio.',
            'start_date.required_if' => 'El campo :attribute es obligatorio.',
            'end_date.required_if' => 'El campo :attribute es obligatorio.',
        ];
    }
}
