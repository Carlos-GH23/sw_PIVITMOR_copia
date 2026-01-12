<?php

namespace App\Http\Requests\AcademicGroups;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;

class UpdateAcademicBodyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'consolidation_degree_id' => ['required', 'integer', 'exists:consolidation_degrees,id'],
            'key' => ['required', 'string', 'max:50'],
            'review' => ['required', 'max:2000', 'string'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'academics' => ['required', 'array', 'min:1'],
            'academics.*' => ['required', 'integer', 'exists:academics,id'],
            'research_lines' => ['nullable', 'array'],
            'research_lines.*' => ['nullable', 'integer', 'exists:research_lines,id'],
            'knowledge_lines' => ['sometimes', 'array', 'min:1'],
            'knowledge_lines.*.name' => ['required', 'string', 'max:255'],
            'economic_sectors' => ['required', 'array', 'min:1'],
            'economic_sectors.*' => ['required', 'integer', 'exists:economic_sectors,id'],
            'oecd_sectors' => ['required', 'array', 'min:1'],
            'oecd_sectors.*' => ['required', 'integer', 'exists:oecd_sectors,id'],
        ], $this->filesRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'name'                      => 'nombre del cuerpo académico',
            'consolidation_degree_id'   => 'grado de consolidación',
            'key'                       => 'clave',
            'academic_discipline_id'    => 'área y disciplina',
            'review'                    => 'reseña',
            'department_id'             => 'departamento',
            'academics'                 => 'profesores',
            'academics.*'               => 'profesor',
            'research_lines'            => 'líneas de investigación',
            'research_lines.*'          => 'línea de investigación',
            'knowledge_lines'           => 'LGAC asociadas',
            'knowledge_lines.*.name'    => 'nombre de la LGAC',
            'economic_sectors'          => 'sectores económicos y productivos',
            'economic_sectors.*'        => 'sector económico y productivo',
            'oecd_sectors'              => 'disciplinas cientificas y tecnológicas',
            'oecd_sectors.*'            => 'disciplina cientifica y tecnológica',
        ], $this->filesAttributes());
    }
}
