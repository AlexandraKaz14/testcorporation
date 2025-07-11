<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Jobs\SendTestModerationNotificationJob;
use App\Models\Test;

class SendTestModerationNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Test $test): void
    {
        if ($test->wasChanged('status') && $test->status === Test::STATUS_MODERATION) {
            SendTestModerationNotificationJob::dispatch($test);
        }
    }
}
