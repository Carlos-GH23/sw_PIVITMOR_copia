<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
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
            'question' => 'required|string|max:2000',
            'answer' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'El campo de la pregunta es obligatorio.',
            'question.string' => 'El campo de la pregunta debe ser una cadena de texto.',
            'question.max' => 'El campo de la pregunta no puede tener más de 255 caracteres.',
            'answer.required' => 'El campo de la respuesta es obligatorio.',
            'answer.string' => 'El campo de la respuesta debe ser una cadena de texto.',
        ];
    }
}
