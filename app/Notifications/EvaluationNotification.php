<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Traits\ConstructEmailTemplate;

class EvaluationNotification extends Notification implements ShouldQueue
{
    use Queueable, ConstructEmailTemplate;
    private Model $model;

    /**
     * Create a new notification instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        [$label, $route] = $this->getTypeData();

        $variables = [
            '{{ title }}'      => $this->model->title ?? '',
            '{{ user_name }}'   => $notifiable->name,
            '{{ label }}'       => $label,
            '{{ link }}'        => $route,
        ];

        return $this->buildMailMessage('evaluation', $variables);
    }

    /**
     * Notificación para base de datos (ej. in-app).
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Detecta tipo y construye descripción + ruta.
     */
    private function getTypeData(): array
    {
        return match (class_basename($this->model)) {
            'Capability' => ['capacidad', route('capabilities.show', $this->model->id)],
            'Requirement' => ['necesidad', route('requirements.show', $this->model->id)],
            'TechnologyService' => ['servicio tecnológico', route('technologyServices.show', $this->model->id)],
            default => ['gestión', url('/')],
        };
    }
}
