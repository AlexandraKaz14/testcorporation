<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\TakingTest;
use App\Models\Test;
use App\Models\User;
use App\Notifications\DailyStatisticsNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendDailyStatisticsJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $yesterday = Carbon::yesterday();

        $newUsers = User::whereDate('created_at', $yesterday)->count();
        $newTestsAll = Test::whereDate('created_at', $yesterday)->count();
        $activeTests = Test::where('status', Test::STATUS_ACTIVE)
            ->whereDate('created_at', $yesterday)
            ->count();
        $passingTests = TakingTest::where('is_temporary', false)
            ->whereDate('created_at', $yesterday)
            ->count();

        $message = "*📊 Статистика за {$yesterday->format('d.m.Y')}*\n\n";
        $message .= "👥 Новых пользователей: *{$newUsers}*\n";
        $message .= "📝 Новых тестов всего: *{$newTestsAll}*\n";
        $message .= "👍 Новых тестов опубликованных: *{$activeTests}*\n";
        $message .= "✅ Пройдено тестов: *{$passingTests}*\n";

        $chatId = config('services.telegram-bot-api.channel_id');

        Notification::route('telegram', $chatId)
            ->notify(new DailyStatisticsNotification($message));

    }
}
