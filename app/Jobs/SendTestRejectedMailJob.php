<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Moderation;
use App\Notifications\TestRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendTestRejectedMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $moderation;

    public function __construct(Moderation $moderation)
    {
        $this->moderation = $moderation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->moderation->test->user->notify(new TestRejectedNotification($this->moderation->test));
    }
}
