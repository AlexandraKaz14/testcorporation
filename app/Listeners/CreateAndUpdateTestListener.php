<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Jobs\MetaTagsJob;
use App\Models\Test;

class CreateAndUpdateTestListener
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
        if (!$test->isDirty(['meta_keywords', 'meta_description'])) {
            MetaTagsJob::dispatch($test);
        }
    }
}
