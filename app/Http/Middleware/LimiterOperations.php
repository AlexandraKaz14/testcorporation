<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class LimiterOperations
{
    protected RateLimiter $limiter;

    protected static string $key;

    protected static array $limit = [];

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();

        static::$limit = config('ratelimits', []);
        static::$limit = isset(static::$limit[$routeName]) ? static::$limit[$routeName] : [];
        if (!$routeName || !static::$limit) {
            return $next($request);
        }
        static::$key = $routeName . '-' . ($request->user() ? $request->user()->id : $request->ip());

        if ($this->limiter->tooManyAttempts(static::$key, static::$limit['limit'])) {
            $message = static::$limit['message'];
            $message = strtr($message, [
                ':limit:' => static::$limit['limit'],
            ]);
            return redirect()->back()
                ->withErrors([
                    'error' => $message,
                ]);

        }

        return $next($request);
    }

    public function terminate($request, Response $response)
    {
        if (static::$limit && !$response->isClientError() && !$response->isServerError()) {
            $this->limiter->hit(static::$key, 60 * static::$limit['minutes']);
        }
    }
}
