<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTechnologyLevelRequest extends FormRequest
{
    protected string $tableName = 'tlrLevels';
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'required|max:255',
            'level'           => [
                'required',
                Rule::unique('technology_levels', 'level')->whereNull('deleted_at')
            ],
        ];
    }
    public function attributes(): array
    {
        return [
            'level'           => 'nivel',
            'name'        => 'nombre',
        ];
    }
}
