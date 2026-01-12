<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
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
            'name'        =>[
                'required',
                Rule::unique('activities', 'name')->whereNull('deleted_at')
            ],
            'description' => 'nullable|max:2000|string',
            'parent_id'   => "nullable",
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nombre',
            'description' => 'descripción',
            'parent_id'   => 'actividad padre',
        ];
    }
}
