<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\PhoneNumberRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactInformationRequest extends FormRequest
{
    use PhoneNumberRules;
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
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'opening_time' => ['required', 'date_format:H:i'],
            'closing_time' => ['required', 'date_format:H:i', 'after:opening_time'],
        ], $this->phoneNumberRules());
    }

     public function attributes(): array
    {
        return array_merge([
            'email' => 'correo electrónico',
            'address' => 'dirección',
            'latitude' => 'latitud',
            'longitude' => 'longitud',
            'opening_time' => 'hora de apertura',
            'closing_time' => 'hora de cierre',
        ], $this->phoneNumberAttributes());
    }
}
