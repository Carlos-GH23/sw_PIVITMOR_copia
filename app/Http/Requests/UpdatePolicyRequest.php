<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePolicyRequest extends FormRequest
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
            'cookies_policy' => 'required|string|max:5000',
            'terms_and_conditions' => 'required|string|max:5000',
            'legal_references' => 'nullable|url'
        ];
    }

    public function attributes()
    {
        return [
            'cookies_policy' => 'política de cookies',
            'terms_and_conditions' => 'términos y condiciones',
            'legal_references' => 'referencias legales'
        ];
    }
}
