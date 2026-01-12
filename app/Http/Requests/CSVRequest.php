<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CSVRequest extends FormRequest
{
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
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'csv' => 'archivo CSV',
            'model_class' => 'clase del modelo',
        ];
    }
}