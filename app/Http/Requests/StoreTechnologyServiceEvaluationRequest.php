<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnologyServiceEvaluationRequest extends FormRequest
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
            'body' => 'required|max:255',
            'is_visible' => 'required|boolean',
            'technology_service_status_id' => 'required|integer|exists:technology_service_statuses,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'body' => 'observaciones',
            'technology_service_status_id' => 'estatus',
        ];
    }
}
