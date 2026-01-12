<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\PhotoRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreRequirementRequest extends FormRequest
{
    use PhotoRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('requirements.evaluations.store')) {
            return in_array($this->input('requirement_status_id'), [1, 3]);
        }

        return in_array($this->input('requirement_status_id'), [1, 2]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $statusBasedRule = ((int)$this->input('requirement_status_id') === 2 || (int)$this->input('requirement_status_id') === 3)
            ? 'required' : 'nullable';

        return array_merge(
            [
                'title'                     => ['required', 'string', 'max:400'],
                'technical_description'     => [$statusBasedRule, 'string', 'max:2000'],
                'need_statement'            => [$statusBasedRule, 'string', 'max:2000'],
                'potential_applications'    => [$statusBasedRule, 'string', 'max:2000'],
                'start_date'                => [$statusBasedRule, 'date'],
                'end_date'                  => [$statusBasedRule, 'date', 'after_or_equal:start_date'],

                'requirement_status_id'     => ['required', 'integer', 'exists:requirement_statuses,id'],
                'intellectual_property_id'  => [$statusBasedRule, 'integer', 'exists:intellectual_properties,id'],
                'technology_level_id'       => [$statusBasedRule, 'integer', 'exists:technology_levels,id'],

                'oecd_sectors'              => [$statusBasedRule, 'array'],
                'oecd_sectors.*'            => ['integer', 'exists:oecd_sectors,id'],
                'economic_sectors'          => [$statusBasedRule, 'array'],
                'economic_sectors.*'        => ['integer', 'exists:economic_sectors,id'],
                'keywords'                  => [$statusBasedRule, 'array', 'max:5'],
                'keywords.*.name'           => ['required_with:keywords', 'string', 'max:50'],
            ],
            $this->photoRules()
        );
    }

    public function attributes(): array
    {
        return array_merge(
            $this->photoAttributes(),
            [
                'title'                     => 'título',
                'technical_description'     => 'descripción técnica',
                'need_statement'            => 'problema que resuelve',
                'potential_applications'    => 'aplicaciones potenciales',
                'start_date'                => 'fecha de inicio',
                'end_date'                  => 'fecha de término',

                'requirement_status_id'     => 'estatus',
                'intellectual_property_id'  => 'propiedad intelectual',
                'technology_level_id'       => 'nivel de madurez tecnológica',

                'oecd_sectors'              => 'disciplinas científicas y tecnológicas',
                'oecd_sectors.*'            => 'disciplina científica y tecnológica',
                'economic_sectors'          => 'sectores económicos y productivos',
                'economic_sectors.*'        => 'sector económico y productivo',
                'keywords'                  => 'palabras clave',
                'keywords.*.name'           => 'palabra clave',
            ]
        );
    }

    protected function failedAuthorization()
    {
        abort(403);
    }
}
