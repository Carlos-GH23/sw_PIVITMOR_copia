<?php

namespace App\Http\Requests\Catalogs;

use App\Enums\ImpactMetricType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImpactMetricRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'value' => ['nullable', 'integer'],
            'type' => ['required', 'string', Rule::in(ImpactMetricType::values())],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'value' => 'valor',
            'type' => 'tipo',
        ];
    }
}
