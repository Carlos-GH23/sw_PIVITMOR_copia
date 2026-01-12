<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKnowledgeAreaRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                // This rule ensures the name is unique within its parent.
                // It allows for duplicate names if they have different parents.
                Rule::unique('knowledge_areas', 'name')->where(function ($query) {
                    $query->where('parent_id', $this->parent_id);
                }),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:knowledge_areas,id'
            ],
        ];
    }

    /**
     * Get the custom attributes for validator errors.
     *
     * @return array<string, string>
     */    
    public function attributes(): array
    {
        return [
            'name'      => 'nombre',
            'parent_id' => 'área de conocimiento padre',
        ];  
    }
}