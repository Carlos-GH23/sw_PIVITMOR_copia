<?php

namespace App\Notifications;

use App\Models\Capability;
use App\Models\CapabilityRequirementMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Traits\ConstructEmailTemplate;

class MatchResponseNotification extends Notification implements ShouldQueue
{
    use Queueable, ConstructEmailTemplate;
    private CapabilityRequirementMatch $capabilityRequirementMatch;
    private Model $model;

    /**
     * Create a new notification instance.
     */
    public function __construct(CapabilityRequirementMatch $capabilityRequirementMatch, Model $model)
    {
        $this->capabilityRequirementMatch = $capabilityRequirementMatch;
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
        [$label,$actor, $route] = $this->getTypeData();

        $variables = [
            '{{ user_name }}'   => $notifiable->name,
            '{{ actor }}'       => $actor,
            '{{ link }}'        => $route,
            '{{ label }}'       => $label,
            '{{ title }}'       => $this->model->title ?? '',
        ];

        return $this->buildMailMessage('match_response', $variables);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    private function getTypeData(): array
    {
        return match (class_basename($this->model)) {
            'Requirement' => ['necesidad', 'demandante', route('requirements.matches.index', $this->capabilityRequirementMatch->id)],
            'Capability' => ['oferta', 'ofertante', route('capabilities.matches.index', $this->capabilityRequirementMatch->id)], // cambiar por capabilities
            default => ['vinculación', url('/')],
        };
    }
}
