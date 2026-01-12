<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\Traits\ContactRules;
use App\Http\Requests\Traits\FileValidationRules;
use App\Http\Requests\Traits\LocationRules;
use App\Http\Requests\Traits\PhoneNumberRules;
use App\Http\Requests\Traits\SocialLinkRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    use LocationRules, ContactRules, PhoneNumberRules, SocialLinkRules, FileValidationRules;

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
            'name'          => 'required|string|max:255',
            'legal_name'    => 'required|string|max:255',
            'rfc'           => 'required|alpha_num|max:13',
            'year'          => 'required|digits:4',
            'mission'       => 'nullable|string|max:2000',
            'vision'        => 'nullable|string|max:2000',
            'overview'      => 'nullable|string|max:2000',
            'keywords'          => 'required|array|max:5',
            'keywords.*.name'   => 'required|string|max:50',

            'logo'              => 'nullable',
            'logo.id'           => 'nullable|integer|exists:photos,id',
            'logo.file'         => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo.delete_photo' => 'boolean',

            'reniecyt.register_number' => 'nullable|string|max:50|unique:reniecyts,register_number,' . $this->user()->company->reniecyt?->id . '|required_with:reniecyt.start_date,reniecyt.end_date',
            'reniecyt.start_date'      => 'nullable|date|required_with:reniecyt.register_number,reniecyt.end_date',
            'reniecyt.end_date'        => 'nullable|date|after:reniecyt.start_date|required_with:reniecyt.register_number,reniecyt.start_date',

            'technology.has_company'    => 'required|boolean',
            'technology.description'    => 'required_if:technology.has_company,true|nullable|string|max:2000',
            'technology.num_employees'  => 'required_if:technology.has_company,true|nullable|integer|min:1',
            'technology.origen_id'      => 'required_if:technology.has_company,true|nullable|integer|exists:origens,id',
            'technology.innovation_type_id' => 'required_if:technology.has_company,true|nullable|integer|exists:innovation_types,id',
            'technology.market_reach_id'    => 'required_if:technology.has_company,true|nullable|integer|exists:market_reaches,id',
            'technology.company_size_id'    => 'required_if:technology.has_company,true|nullable|integer|exists:company_sizes,id',
            'technology.technology_level_id' => 'required_if:technology.has_company,true|nullable|integer|exists:technology_levels,id',

            'oecd_sectors'          => ['nullable', 'array'],
            'oecd_sectors.*'        => ['integer', 'exists:oecd_sectors,id'],
            'economic_sectors'      => ['nullable', 'array'],
            'economic_sectors.*'    => ['integer', 'exists:economic_sectors,id'],
        ], $this->contactRules(), $this->LocationRules(), $this->phoneNumberRules(), $this->socialLinkRules(), $this->filesRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'logo.file'     => 'logo',
            'name'          => 'nombre',
            'legal_name'    => 'nombre legal',
            'rfc'           => 'RFC',
            'year'          => 'año de inicio',
            'mission'       => 'misión',
            'vision'        => 'visión',
            'overview'      => 'resumen',
            'keywords'      => 'palabras clave',
            'keywords.*.name'   => 'palabra clave',

            'reniecyt.register_number'  => 'número de registro',
            'reniecyt.start_date'       => 'fecha inicio',
            'reniecyt.end_date'         => 'fecha fin',

            'technology.has_company'    => 'cuenta con empresa tecnología',
            'technology.description'    => 'descripción',
            'technology.num_employees'  => 'número de empleados',
            'technology.origen_id'      => 'origen',
            'technology.innovation_type_id' => 'tipo de innovación',
            'technology.market_reach_id'    => 'alcance del mercado',
            'technology.company_size_id'    => 'tamaño de la empresa',
            'technology.technology_level_id' => 'nivel tecnológico',

            'oecd_sectors'          => 'disciplinas OCDE',
            'economic_sectors'      => 'sectores económicos',
        ], $this->contactAttributes(), $this->LocationAttributes(), $this->phoneNumberAttributes(), $this->socialLinkAttributes(), $this->filesAttributes());
    }

    public function messages()
    {
        return [
            'technology.description.required_if' => 'El campo descripción es obligatorio.',
            'technology.num_employees.required_if' => 'El campo número de empleados es obligatorio.',
            'technology.origen_id.required_if' => 'El campo origen es obligatorio.',
            'technology.innovation_type_id.required_if' => 'El campo tipo de innovación es obligatorio.',
            'technology.market_reach_id.required_if' => 'El campo alcance del mercado es obligatorio.',
            'technology.company_size_id.required_if' => 'El campo tamaño de la empresa es obligatorio.',
            'technology.technology_level_id.required_if' => 'El campo nivel tecnológico es obligatorio.',
        ];
    }
}
