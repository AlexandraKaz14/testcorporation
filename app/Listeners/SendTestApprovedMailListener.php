<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Jobs\SendTestApprovedMailJob;
use App\Models\Moderation;

class SendTestApprovedMailListener
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
    public function handle(Moderation $moderation): void
    {
        if ($moderation->wasChanged('moderation_status') && $moderation->moderation_status === Moderation::MODERATION_STATUS_APPROVED) {
            SendTestApprovedMailJob::dispatch($moderation);
        }
    }
}
