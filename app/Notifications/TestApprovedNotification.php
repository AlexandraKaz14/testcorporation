<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestApprovedNotification extends Notification
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
            'message' => "Ваш тест '{$this->test->title}' успешно опубликован!",
            'test_url' => route('player.open', [
                'slug' => $this->test->slug,
            ]),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->success()
            ->subject('Ваш тест опубликован!')
            ->greeting('Здравствуйте!')
            ->line("Ваш тест '{$this->test->title}' прошел модерацию и успешно опубликован в каталоге тестов")
            ->action('Посмотреть тест', route('player.open', [
                'slug' => $this->test->slug,
            ]))
            ->line('Спасибо за создание теста!')
            ->line('Продолжайте создавать интересные, увлекательные, познавательные тесты — мы уверены, что у вас еще много замечательных идей!');
    }
}
