<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\CustomLoginEvent;
use App\Events\CustomRegistrationEvent;
use App\Jobs\PostHogIdentifyJob;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use PostHog\PostHog;

class PostHogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!config('posthog.enabled')) {
            return;
        }

        PostHog::init(config('posthog.key'), [
            'host' => config('posthog.host'),
        ]);
        Event::listen([CustomRegistrationEvent::class, CustomLoginEvent::class], [$this, 'callbackIdentify']);
    }

    public function callbackIdentify($event)
    {
        $cookieName = 'ph_' . config('posthog.key') . '_posthog';
        if (isset($_COOKIE[$cookieName])) {
            $postHogUuid = json_decode($_COOKIE[$cookieName])->distinct_id ?? null;
            $user = auth()
                ->user();
            if ($postHogUuid && $user) {
                PostHogIdentifyJob::dispatch($user, $postHogUuid);
            }
        }
    }
}
