<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;

class CommunicationRequest extends FormRequest
{
    use FileValidationRules;
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
        return array_merge(
            $this->filesRules(),
            [
                'subject' => ['required', 'string', 'max:255'],
                'body' => ['required'],
                'footer' => ['required'],
                'recipients' => ['required'],
                'recipients.*' => ['required'],
                'status' => ['required'],
            ]
        );
    }

    public function attributes(): array
    {
        return array_merge(
            $this->filesAttributes(),
            [
                'subject' => 'asunto',
                'body' => 'cuerpo',
                'recipients' => 'destinatarios',
                'status' => 'estatus',
            ]
        );
    }
}
