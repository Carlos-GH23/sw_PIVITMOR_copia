<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MailSetting;

class UpdateMailSettingRequest extends FormRequest
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
        $exists = MailSetting::exists();
        return [
            'username' => ['required', 'string', 'max:255'],
            'password' => [$exists ? 'nullable' : 'required', 'string', 'max:255'],
            'from_address' => ['required', 'email', 'max:255'],
            'from_name' => ['required', 'string', 'max:255'],
            'host' => ['required', 'string', 'max:255'],
            'port' => ['required', 'integer'],
            'trust' => ['nullable', 'string', 'max:255'],
            'protocol' => ['required', 'string', 'max:255'],
            'encoding' => ['required', 'string', 'max:255'],
            'debug' => ['required', 'boolean'],
            'auth_enabled' => ['required', 'boolean'],
            'encryption' => ['nullable', 'string', 'max:255'],
            'starttls_enabled' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'nombre de usuario',
            'password' => 'contraseña',
            'from_address' => 'dirección de correo electrónico del remitente',
            'from_name' => 'nombre del remitente',
            'host' => 'servidor SMTP',
            'port' => 'puerto SMTP',
            'trust' => 'confianza',
            'protocol' => 'protocol',
            'encoding' => 'codificación',
            'debug' => 'depuración',
            'auth_enabled' => 'autenticación habilitada',
            'encryption' => 'cifrado',
            'starttls_enabled' => 'STARTTLS habilitado',
        ];
    }
}
