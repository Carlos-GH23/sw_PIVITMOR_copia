<?php

namespace App\Notifications;

use App\Models\Notice\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Traits\ConstructEmailTemplate;

class NoticeNotification extends Notification implements ShouldQueue
{
    use Queueable, ConstructEmailTemplate;

    private Notice $notice;
    /**
     * Create a new notification instance.
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
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
        $title = $this->notice->title;
        $url = route('welcome.notices.details', [
            'slug' => $this->notice->slug,
            'id'   => $this->notice->id
        ]);

        $variables = [
            '{{ user_name }}'   => $notifiable->name,
            '{{ notice_title }}' => $title,
            '{{ notice_url }}'   => $url,
        ];

        return $this->buildMailMessage('notice_published', $variables);
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
