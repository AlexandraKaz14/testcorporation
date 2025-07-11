<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TestModerationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $test;

    public function __construct(Test $test)
    {
        $this->test = $test;

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

    public function toTelegram($notifiable)
    {
        $chatId = config('services.telegram-bot-api.channel_id');

        $url = route('admin.tests.show', [
            'test' => $this->test->id,
        ]);
        return TelegramMessage::create()
            ->to($chatId)
            ->content("📢 *Тест отправлен на модерацию!*\n\n")
            ->line("*Название*: {$this->test->title}")
            ->line("*Автор*: {$this->test->user->name}")
            ->button('👀 Посмотреть тест', $url, 1);
    }
}
