<?php

namespace App\Http\Requests\Institution;

use App\Http\Requests\Traits\ContactRules;
use App\Http\Requests\Traits\LocationRules;
use App\Http\Requests\Traits\PhoneNumberRules;
use App\Http\Requests\Traits\SocialLinkRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInstitutionProfileRequest extends FormRequest
{
    use ContactRules, PhoneNumberRules, SocialLinkRules, LocationRules;
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
            'name'                      => 'required|string|max:255',
            'institution_category_id'   => 'required|integer|exists:institution_categories,id',
            'institution_type_id'       => 'required|integer|exists:institution_types,id',
            'description'               => 'nullable|string|max:2000',

            'logo'              => 'nullable',
            'logo.id'           => 'nullable|integer|exists:photos,id',
            'logo.file'         => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo.delete_photo' => 'boolean',

            'reniecyt.register_number' => 'nullable|string|max:50|unique:reniecyts,register_number,' . $this->user()->institution->reniecyt?->id . '|required_with:reniecyt.start_date,reniecyt.end_date',
            'reniecyt.start_date'      => 'nullable|date|required_with:reniecyt.register_number,reniecyt.end_date',
            'reniecyt.end_date'        => 'nullable|date|after:reniecyt.start_date|required_with:reniecyt.register_number,reniecyt.start_date',

            'oecd_sectors'          => 'nullable|array',
            'oecd_sectors.*'        => 'integer|exists:oecd_sectors,id',
            'knowledge_areas'       => 'nullable|array',
            'knowledge_areas.*'     => 'integer|exists:knowledge_areas,id',
            'economic_sectors'      => 'nullable|array',
            'economic_sectors.*'    => 'integer|exists:economic_sectors,id',

            'keywords'          => 'required|array|max:5',
            'keywords.*.name'   => 'required|string|max:50',
        ], $this->phoneNumberRules(), $this->contactRules(), $this->socialLinkRules(), $this->locationRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'name'                      => 'nombre de la institución',
            'institution_category_id'   => 'categoría',
            'institution_type_id'       => 'tipo de institución',
            'description'               => 'reseña',
            'logo.file'                 => 'logo',

            'reniecyt.register_number'  => 'número de registro RENIECyT',
            'reniecyt.start_date'       => 'fecha de inicio de RENIECyT',
            'reniecyt.end_date'         => 'fecha de fin de RENIECyT',

            'oecd_sectors'          => 'disciplinas OCDE',
            'knowledge_areas'       => 'áreas de conocimiento',
            'economic_sectors'      => 'sectores económicos',
            'keywords'               => 'palabras clave',
            'keywords.*.name' => 'palabra clave',
        ], $this->contactAttributes(), $this->phoneNumberAttributes(), $this->socialLinkAttributes(), $this->locationAttributes());
    }
}
