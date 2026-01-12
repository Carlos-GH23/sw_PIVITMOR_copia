<?php

namespace App\Http\Requests;

use App\Enums\OrganizationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrganizationRegistrationRequest extends FormRequest
{
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
        return [
            'name' => ['required', 'string', 'max:255', 'unique:organization_registrations,name'],
            'email' => ['required', 'email', 'max:255', 'unique:organization_registrations,email'],
            'organization_type' => ['required', 'string', Rule::in(OrganizationType::values())],
            'organization_sector' => ['required', 'string', 'in:publico,privado'],
            'state_id' => ['required', 'exists:states,id'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre de la organización',
            'email' => 'correo electrónico',
            'organization_type' => 'tipo de organización',
            'organization_sector' => 'sector',
            'state_id' => 'estado',
            'municipality_id' => 'municipio',
        ];
    }
}
