<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrivacityComplianceRequest extends FormRequest
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
            'version' => 'required|numeric|min:0',
            'privacity_advice' => 'required|string|max:5000',
            'is_active' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'version' => 'versión',
            'privacity_advice' => 'aviso de privacidad',
            'is_active' => 'activo',
        ];
    }
}
