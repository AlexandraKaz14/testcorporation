<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Test;
use App\Notifications\TestModerationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendTestModerationNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $test;

    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('telegram', config('services.telegram-bot-api.channel_id'))
            ->notify(new TestModerationNotification($this->test));
    }
}
