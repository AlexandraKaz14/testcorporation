<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\CreateAndUpdateTestListener;
use App\Listeners\SendTestApprovedMailListener;
use App\Listeners\SendTestModerationNotificationListener;
use App\Listeners\SendTestRejectedMaiListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Карта слушателей событий приложения.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.created: App\Models\Test' => [
            CreateAndUpdateTestListener::class,
        ],
        'eloquent.updated: App\Models\Test' => [
            CreateAndUpdateTestListener::class,
            SendTestModerationNotificationListener::class,
        ],
        'eloquent.updated: App\Models\Moderation' => [
            SendTestApprovedMailListener::class,
            SendTestRejectedMaiListener::class,
        ],
    ];

    /**
     * Зарегистрировать любые события для вашего приложения.
     */
    public function boot()
    {
        parent::boot();

        // Здесь можно зарегистрировать дополнительные события вручную
    }
}
