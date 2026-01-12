<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequirementEvaluationRequest extends FormRequest
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
            'requirement_status_id' => 'required|integer|exists:requirement_statuses,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'body' => 'comentario',
            'requirement_status_id' => 'estatus',
        ];
    }
}
