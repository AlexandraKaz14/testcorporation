<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class DailyStatisticsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toTelegram($notifiable)
    {
        $chatId = config('services.telegram-bot-api.channel_id');
        return TelegramMessage::create()
            ->to($chatId)
            ->content($this->message);
    }
}
