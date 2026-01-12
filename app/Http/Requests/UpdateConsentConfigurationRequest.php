<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsentConfigurationRequest extends FormRequest
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
            'data_usage_consent' => ['required', 'boolean'],
            'force_acceptance' => ['required', 'boolean'],
            'electronic_communication_consent' => ['required', 'boolean'],
            'electronic_communication_message' => ['required_if:electronic_communication_consent,true', 'string', 'max:500', 'nullable' ],
            'statistical_data_consent' => ['required', 'boolean'],
            'statistical_data_message' => ['required_if:statistical_data_consent,true', 'string', 'max:500', 'nullable' ],
            'frequency_of_acceptance' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'electronic_communication_message.required_if' => 'El mensaje para comunicaciones electrónicas es obligatorio cuando el consentimiento está habilitado.',
            'statistical_data_message.required_if' => 'El mensaje para datos estadísticos es obligatorio cuando el consentimiento está habilitado.',
        ];
    }

    public function attributes(): array
    {
        return [
            'data_usage_consent' => 'Consentimiento para el uso de datos',
            'force_acceptance' => 'Aceptación forzada',
            'electronic_communication_consent' => 'Consentimiento para comunicaciones electrónicas',
            'electronic_communication_message' => 'Mensaje para comunicaciones electrónicas',
            'statistical_data_consent' => 'Consentimiento para datos estadísticos',
            'statistical_data_message' => 'Mensaje para datos estadísticos',
            'frequency_of_acceptance' => 'Frecuencia de aceptación',
        ];
    }
}
