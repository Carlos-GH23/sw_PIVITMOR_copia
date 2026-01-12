<?php

namespace App\Notifications;

use App\Traits\ConstructEmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcademicCredentialsNotification extends Notification implements ShouldQueue
{
    use Queueable, ConstructEmailTemplate;

    public string $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $password)
    {
        $this->password = $password;
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
        $variables = [
            '{{ user_name }}' => $notifiable->name,
            '{{ email }}'     => $notifiable->email,
            '{{ password }}'  => $this->password,
            '{{ link }}'      => url('/login'),
        ];

        return $this->buildMailMessage('academic_credentials', $variables);
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
}
