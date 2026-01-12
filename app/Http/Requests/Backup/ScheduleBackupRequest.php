<?php

namespace App\Http\Requests\Backup;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleBackupRequest extends FormRequest
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
            'backup_frequency_id' => 'required|integer|exists:backup_frequencies,id',
            'time' => 'required|date_format:H:i',
            'email_notification' => 'required|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'backup_frequency_id' => 'frecuencia',
            'time' => 'hora',
            'email_notification' => 'notificaciones por correo',
        ];
    }
}
