<?php

namespace App\Http\Requests\Institution;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\Traits\PhotoRules;

class StoreAcademicRequest extends FormRequest
{
    use PhotoRules;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'required|string|max:100',
            'second_last_name'      => 'nullable|string|max:100',
            'contact.email'         => 'required|email|max:255|unique:users,email',
            'biography'             => 'required|string|max:2000',
            'gender'                => ['required', 'string', Rule::in(Gender::values())],

            'photo'                 => 'nullable',
            'photo.id'              => 'nullable|integer|exists:photos,id',
            'photo.file'            => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'photo.delete_photo'    => 'boolean',

            'knowledge_lines'       => 'required|array|min:1|max:5',
            'knowledge_lines.*name' => 'string|max:255',

            'academic_position_id'  => 'required|exists:academic_positions,id',
            'academic_degree_id'    => 'required|exists:academic_degrees,id',
            'department_id'         => 'required|exists:departments,id',

            'sni.has_sni'           => 'nullable|boolean',
            'sni.number'            => 'nullable|string|max:10',
            'sni.sni_level_id'      => 'required_if:sni.has_sni,true|nullable|exists:sni_levels,id|required_with:sni.research_area_id,sni.start_date,sni.end_date,sni.number',
            'sni.research_area_id'  => 'required_if:sni.has_sni,true|nullable|exists:research_areas,id|required_with:sni.sni_level_id,sni.start_date,sni.end_date,sni.number',
            'sni.start_date'        => 'required_if:sni.has_sni,true|nullable|date|required_with:sni.sni_level_id,sni.research_area_id,sni.end_date,sni.number',
            'sni.end_date'          => 'required_if:sni.has_sni,true|nullable|date|after_or_equal:sni.start_date|required_with:sni.sni_level_id,sni.research_area_id,sni.start_date,sni.number',

            'profile.has_profile'   => 'nullable|boolean',
            'profile.start_date'    => 'required_if:profile.has_profile,true|nullable|date',
            'profile.end_date'      => 'required_if:profile.has_profile,true|nullable|date|after_or_equal:profile.start_date',

            'oecd_sectors'       => 'required|array|min:1',
            'oecd_sectors.*'     => 'integer|exists:oecd_sectors,id',
            'economic_sectors'   => 'required|array|min:1',
            'economic_sectors.*' => 'integer|exists:economic_sectors,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'photo.file'            => 'foto',
            'first_name'            => 'nombre',
            'last_name'             => 'apellido paterno',
            'second_last_name'      => 'apellido materno',
            'contact.email'         => 'correo electrónico',
            'biography'             => 'biografía',
            'gender'                => 'género',

            'knowledge_lines'       => 'líneas de conocimiento',
            'knowledge_lines.*name' => 'nombre de la línea de conocimiento',

            'academic_position_id'  => 'puesto académico',
            'academic_degree_id'    => 'grado de estudios',
            'department_id'         => 'departamento académico',

            'sni.number'            => 'número de SNI',
            'sni.sni_level_id'      => 'nivel SNII',
            'sni.research_area_id'  => 'área de investigación',
            'sni.start_date'        => 'fecha de inicio SNII',
            'sni.end_date'          => 'fecha de fin SNII',

            'profile.has_profile'   => 'tiene perfil',
            'profile.start_date'    => 'fecha de inicio del perfil',
            'profile.end_date'      => 'fecha de fin del perfil',

            'oecd_sectors'       => 'disciplinas OCDE',
            'oecd_sectors.*'     => 'disciplina OCDE',
            'economic_sectors'   => 'sectores económicos',
            'economic_sectors.*' => 'sector económico',
        ];
    }

    public function messages(): array
    {
        return [
            'profile.start_date' => 'El campo fecha de inicio del perfil deseable es obligatorio cuando el campo perfil deseable es Sí.',
            'profile.end_date' => 'El campo fecha de fin del perfil deseable es obligatorio cuando el campo perfil deseable es Sí.',
            'sni.sni_level_id' => 'El campo nivel es obligatorio cuando registras SNII',
            'sni.research_area_id' => 'El campo área es obligatorio cuando registras SNII',
            'sni.start_date' => 'El campo fecha de inicio es obligatorio cuando registras SNII',
            'sni.end_date' => 'El campo fecha fin es obligatorio cuando registras SNII'
        ];
    }
}
