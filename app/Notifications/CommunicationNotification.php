<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;

class CommunicationNotification extends Notification
{
    private string $subject;
    private string $body;
    private string $footer;
    private ?array $attachmentsData;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $subject, string $body, string $footer, ?array $attachmentsData)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->footer = $footer;
        $this->attachmentsData = $attachmentsData;
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
        $body = "<p>Hola <strong>{$notifiable->name}</strong>,</p>" . $this->body;

        $message = (new MailMessage)
            ->subject($this->subject)
            ->markdown('Emails.MailBase', [
                'body' => $body,
                'footer' => $this->footer,
            ]);

        foreach ($this->attachmentsData ?? [] as $attachment) {
            $relativePath = $attachment['path'];
            $fileContents = Storage::disk('public')->get($relativePath);
            if ($fileContents !== null) {
                $message->attachData($fileContents, $attachment['title'], [
                    'mime' => $attachment['mime'],
                ]);
            }
        }

        return $message;
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
