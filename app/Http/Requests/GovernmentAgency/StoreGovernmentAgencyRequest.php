<?php

namespace App\Http\Requests\GovernmentAgency;

use App\Http\Requests\Traits\LocationRules;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\PhoneNumberRules;
use App\Http\Requests\Traits\SocialLinkRules;

class StoreGovernmentAgencyRequest extends FormRequest
{
    use PhoneNumberRules, SocialLinkRules, LocationRules;
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
            'acronym'       => ['required', 'string', 'max:100'],
            'mission'       => ['required', 'string', 'max:1000'],
            'vision'        => ['required', 'string', 'max:1000'],
            'objectives'    => ['required', 'string', 'max:1000'],
            'government_level_id' => ['required', 'integer', 'exists:government_levels,id'],
            'economic_sector_id'  => ['required', 'integer', 'exists:economic_sectors,id'],
            'logo'          => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],

            'location.state_id'         => ['nullable', 'exists:states,id'],
            'location.municipality_id'  => ['nullable', 'exists:municipalities,id'],
            'location.colony_id'        => ['nullable', 'exists:neighborhoods,id'],
            'location.postal_code'      => ['nullable', 'string', 'digits:5'],
            'location.street'           => ['nullable', 'string', 'max:255'],
            'location.exterior_number'  => ['nullable', 'string', 'max:50'],
            'location.interior_number'  => ['nullable', 'string', 'max:50'],
            'location.latitude'         => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude'        => ['nullable', 'numeric', 'between:-180,180'],

            'contact' => 'nullable|array',
            'contact.name' => 'nullable|string|max:255',
            'contact.email' => 'nullable|email|max:255',
            'contact.website' => 'nullable|string|max:255',

            'keywords' => ['required', 'array'],
            'keywords.*.name' => ['required_with:keywords', 'string', 'max:50'],
        ], $this->phoneNumberRules(), $this->socialLinkRules(), $this->locationRules());
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
            'economic_sector_id'  => 'Sector',
            'logo'          => 'Logotipo',

            'location.state_id'         => 'Estado',
            'location.municipality_id'  => 'Municipio',
            'location.colony_id'        => 'Colonia',
            'location.postal_code'      => 'Código Postal',
            'location.street'           => 'Calle',
            'location.exterior_number'  => 'Número Exterior',
            'location.interior_number'  => 'Número Interior',
            'location.latitude'         => 'Latitud',
            'location.longitude'        => 'Longitud',

            'keywords' => 'Palabras clave',
            'keywords.*.name' => 'Nombre de la palabra clave',
        ], $this->phoneNumberAttributes(), $this->socialLinkAttributes(), $this->locationAttributes());
    }
}
