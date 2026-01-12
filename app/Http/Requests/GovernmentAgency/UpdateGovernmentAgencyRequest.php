<?php

namespace App\Http\Requests\GovernmentAgency;

use App\Http\Requests\Traits\LocationRules;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\PhoneNumberRules;
use App\Http\Requests\Traits\SocialLinkRules;
use App\Http\Requests\Traits\ContactRules;

class UpdateGovernmentAgencyRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'acronym'       => ['required', 'string', 'max:20'],
            'mission'       => ['required', 'string', 'max:2000'],
            'vision'        => ['required', 'string', 'max:2000'],
            'objectives'    => ['required', 'string', 'max:2000'],
            'government_level_id' => ['required', 'integer', 'exists:government_levels,id'],
            'government_sector_id'  => ['required', 'integer', 'exists:government_sectors,id'],

            'logo'              => 'nullable',
            'logo.id'           => 'nullable|integer|exists:photos,id',
            'logo.file'         => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo.delete_photo' => 'boolean',

            'keywords' => ['required', 'array'],
            'keywords.*.name' => ['required_with:keywords', 'string', 'max:50'],
        ], $this->phoneNumberRules(), $this->socialLinkRules(), $this->locationRules(), $this->contactRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'name'          => 'Nombre',
            'acronym'       => 'Acrónimo',
            'mission'       => 'Misión',
            'vision'        => 'Visión',
            'objectives'    => 'Objetivos',
            'government_level_id' => 'Nivel de Gobierno',
            'government_sector_id'  => 'Sector',
            'logo'                      => 'logo',

            'keywords' => 'Palabras clave',
            'keywords.*.name' => 'Nombre de la palabra clave',
        ], $this->contactAttributes(), $this->phoneNumberAttributes(), $this->socialLinkAttributes(), $this->locationAttributes());
    }
}
