<?php

declare(strict_types=1);

use App\Console\Commands\CalculateRatings;
use App\Console\Commands\DeletedTemporaryResult;
use App\Http\Middleware\CheckBlocked;
use App\Jobs\SendDailyStatisticsJob;
use App\Services\TelegramErrorNotificationService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            ConvertEmptyStringsToNull::class,
            CheckBlocked::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command(DeletedTemporaryResult::class)->everyFiveMinutes();
        $schedule->command(CalculateRatings::class)->everyFiveMinutes();
        $schedule->job(new SendDailyStatisticsJob())
            ->dailyAt('06:00');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        Integration::handles($exceptions);
        $exceptions->report(function (Throwable $exception) {
            $notificationService = app(TelegramErrorNotificationService::class);
            $notificationService->sendExceptionNotification($exception);
        });
    })->create();
