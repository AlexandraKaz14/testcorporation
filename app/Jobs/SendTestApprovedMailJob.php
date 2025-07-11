<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Moderation;
use App\Notifications\TestApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTestApprovedMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
        $this->moderation->test->user->notify(new TestApprovedNotification($this->moderation->test));

    }
}
