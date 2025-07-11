<?php

declare(strict_types=1);

return [
    'enabled' => env('POSTHOG_ENABLED', false),
    'host' => env('POSTHOG_HOST', 'https://app.posthog.com'),
    'key' => env('POSTHOG_KEY', ''),
    'user_prefix' => 'user',
];
