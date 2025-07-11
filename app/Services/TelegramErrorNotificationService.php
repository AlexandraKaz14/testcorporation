<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TelegramErrorNotificationService
{
    protected ?string $botToken;

    protected ?string $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram-bot-api.token');
        $this->chatId = config('services.telegram-bot-api.channel_id');
    }

    public function sendExceptionNotification(Exception $exception): void
    {
        if (!$this->botToken || !$this->chatId) {
            return;
        }

        $message = $this->formatExceptionMessage($exception);
        $client = new Client();

        try {
            $client->post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'json' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'parse_mode' => 'MarkdownV2',
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Ошибка отправки сообщения в Telegram: ' . $e->getMessage());
        }
    }

    protected function formatExceptionMessage(Exception $exception): string
    {
        $message = "🚨 *Ошибка в приложении* 🚨\n";
        $message .= "```\n";
        $message .= 'Сообщение: ' . $this->escapeMarkdown($exception->getMessage()) . "\n";
        $message .= 'Файл: ' . $this->escapeMarkdown($exception->getFile()) . "\n";
        $message .= 'Строка: ' . $exception->getLine() . "\n";
        $message .= "```\n";
        $message .= "Трассировка:\n```\n" .
            $this->escapeMarkdown(implode("\n", array_slice(explode("\n", $exception->getTraceAsString()), 0, 5))) .
            "\n```";

        return $message;
    }

    protected function escapeMarkdown(string $text): string
    {
        $characters = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];

        foreach ($characters as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }

        return $text;
    }
}
