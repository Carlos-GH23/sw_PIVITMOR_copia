<?php

namespace App\Http\Requests\Company;

use App\Enums\Gender;
use App\Http\Requests\Traits\PhoneNumberRules;
use App\Http\Requests\Traits\SocialLinkRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreJobOfferRequest extends FormRequest
{
    use PhoneNumberRules, SocialLinkRules;
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
            'position' => 'required|string|max:255',
            'gender' => ['required', new Enum(Gender::class)],
            'travel_requirements' => 'nullable|boolean',
            'job_offer_type_id' => 'required|integer|exists:job_offer_types,id',
            'academic_degree_id' => 'nullable|integer|exists:academic_degrees,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'job_description' => 'required|string|max:2000',
            'responsibilities' => 'required|string|max:2000',
            'skills_languages' => 'nullable|string|max:2000',
            'observations' => 'nullable|string|max:2000',
            'comments' => 'nullable|string|max:2000',
            'contact' => 'array',
            'contact.id' => 'nullable|integer|exists:contacts,id',
            'contact.name' => 'nullable|string|max:255',
            'contact.email' => 'nullable|email|max:255',
            'contact.website' => 'nullable|string|max:255',
            'oecd_sectors' => 'nullable|array',
            'oecd_sectors.*' => 'integer|exists:oecd_sectors,id',
            'economic_sectors' => 'nullable|array',
            'economic_sectors.*' => 'integer|exists:economic_sectors,id',
        ], $this->phoneNumberRules(), $this->socialLinkRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'name' => 'nombre',
            'position' => 'puesto',
            'gender' => 'género',
            'travel_requirements' => 'requisitos de viaje',
            'job_offer_type_id' => 'tipo de oferta',
            'academic_degree_id' => 'grado académico',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha de cierre',
            'job_description' => 'descripción del trabajo',
            'responsibilities' => 'responsabilidades',
            'skills_languages' => 'habilidades y lenguajes',
            'observations' => 'observaciones',
            'comments' => 'comentarios',
            'contact' => 'contacto',
            'contact.name' => 'nombre del contacto',
            'contact.email' => 'correo electrónico del contacto',
            'contact.website' => 'sitio web del contacto',
        ], $this->phoneNumberAttributes(), $this->socialLinkAttributes());
    }


}
