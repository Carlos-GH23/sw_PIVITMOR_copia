<?php

namespace App\Http\Requests\Catalogs;

use App\Models\Module;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTechnologyLevelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'required|max:255',
            'level'           => [
                'required',
                Rule::unique('technology_levels', 'level')->ignore($this->technologyLevel->id)->whereNull('deleted_at')
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
