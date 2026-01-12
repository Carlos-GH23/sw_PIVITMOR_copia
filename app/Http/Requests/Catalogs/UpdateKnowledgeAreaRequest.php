<?php

namespace App\Http\Requests\Catalogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKnowledgeAreaRequest extends FormRequest
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
        // Obtiene el ID del área de conocimiento desde el binding de la ruta.
        $knowledgeAreaId = $this->route('knowledgeArea')->id ?? null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('knowledge_areas')->ignore($knowledgeAreaId),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('knowledge_areas', 'id'),
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */    
    public function attributes(): array
    {
        return [
            'name'      => 'nombre',
            'parent_id' => 'área padre',
        ];
    }
}
