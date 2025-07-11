<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestRejectedNotification extends Notification
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
        return ['database', 'mail'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Ваш тест '{$this->test->title}' был отклонен.",
            'reason' => $this->test->moderation->rejection_reason,
            'test_url' => route('author.tests.show', [
                'test' => $this->test->id,
            ]),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->error()
            ->subject('Ваш тест не прошел модерацию')
            ->greeting('Здравствуйте!')
            ->line("Ваш тест '{$this->test->title}' не прошел модерацию и не был опубликован в каталоге тестов")
            ->line("Причина отказа в публикации: {$this->test->moderation->rejection_reason}")
            ->action('Посмотреть тест', route('author.tests.show', [
                'test' => $this->test->id,
            ]))
            ->line('Вы можете исправить тест и отправить на модерацию снова.');
    }
}
