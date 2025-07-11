<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PostHog\PostHog;

class PostHogIdentifyJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private User $user;

    private string $posHogUuid;

    public function __construct(User $user, string $posHogUuid)
    {
        $this->user = $user;
        $this->posHogUuid = $posHogUuid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PostHog::identify([
            'distinctId' => $this->posHogUuid,
            'properties' => [
                'email' => $this->user->email,
                'name' => $this->user->name,
            ],
        ]);
    }
}
