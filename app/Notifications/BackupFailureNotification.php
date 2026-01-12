<?php

namespace App\Notifications;

use App\Traits\ConstructEmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BackupFailureNotification extends Notification implements ShouldQueue
{
    use Queueable, ConstructEmailTemplate;

    public $filename;
    public $error;

    public function __construct($filename, $error)
    {
        $this->filename = $filename;
        $this->error = $error;
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
            '{{ user_name }}'      => $notifiable->name,
            '{{ filename }}'  => $this->filename,
            '{{ date }}'      => now()->format('d/m/Y H:i:s'),
            '{{ error }}'     => $this->error,
        ];

        return $this->buildMailMessage('backup_failure', $variables);
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
