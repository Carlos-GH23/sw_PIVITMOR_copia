<?php

namespace App\Notifications;

use App\Traits\ConstructEmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BackupSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable, ConstructEmailTemplate;

    public $filename;
    public $backupLog;

    /**
     * Create a new notification instance.
     */
    public function __construct($filename, $backupLog = null)
    {
        $this->filename = $filename;
        $this->backupLog = $backupLog;
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
            '{{ location }}'  => config('backup.backup.name'),
        ];

        return $this->buildMailMessage('backup_success', $variables);
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
