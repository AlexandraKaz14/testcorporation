<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Test;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TestAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $test = Test::where('slug', $request->route('slug'))
            ->firstOrFail();

        if ($test->isActive() || ($user && ($user->id === $test->user_id || $user->isAdmin()))) {
            return $next($request);
        }

        abort(403, 'Access denied');
    }
}
