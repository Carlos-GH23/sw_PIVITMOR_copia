<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\LocationRules;
use App\Http\Requests\Traits\PhoneNumberRules;
use App\Http\Requests\Traits\SocialLinkRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNonProfitOrganizationProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'cluni' => 'nullable|string|max:255',
            'rfc'  => 'required|string|max:255',
            'mission' => 'nullable|string|max:2000',
            'main_projects' => 'nullable|string|max:2000',
            'description' => 'nullable|string|max:2000',
            'legal_representative' => 'required|string|max:255',
            'legal_entity_type_id' => 'required|integer|exists:legal_entity_types,id',
            'economic_sector_id' => 'required|integer|exists:economic_sectors,id',
            'market_reach_id' => 'required|integer|exists:market_reaches,id',

            'logo' => 'nullable',
            'logo.id' => 'nullable|integer|exists:photos,id',
            'logo.file' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo.delete_photo' => 'boolean',

            'keywords' => ['required', 'array', 'max:5'],
            'keywords.*.name' => ['required', 'string', 'max:50'],

            'contact' => 'array',
            'contact.id' => 'nullable|integer|exists:contacts,id',
            'contact.name'      => 'nullable|string|max:255',
            'contact.email'     =>  ['nullable', 'email', 'max:255', Rule::unique('contacts', 'email')->ignore($this->contact['id']) ?? null],
            'contact.website'   => 'nullable|url',
        ], $this->locationRules(),  $this->phoneNumberRules(), $this->socialLinkRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'name' => 'nombre oficial',
            'cluni' => 'cluni',
            'rfc' => 'rfc',
            'logo' => 'logo',
            'mission' => 'objetivo social/misión',
            'main_projects' => 'proyectos principales',
            'description' => 'reseña',
            'legal_representative' => 'representante legal',
            'legal_entity_type_id' => 'tipo de entidad legal',
            'economic_sector_id' => 'sector',
            'market_reach_id' => 'ámbito de actuación',

            'keywords' => 'palabras clave',
            'keywords.*.name' => 'palabra clave',

            'contact' => 'contacto',
            'contact.name' => 'nombre',
            'contact.email' => 'correo electrónico',
            'contact.website' => 'página web',

        ], $this->phoneNumberAttributes(), $this->socialLinkAttributes());
    }
}
