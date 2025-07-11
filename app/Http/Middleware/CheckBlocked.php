<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->status !== User::STATUS_ACTIVE)) {
            Auth::logout();
            $request->session()
                ->invalidate();
            $request->session()
                ->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'email' => __('auth.blocked'),
                ]);
        }
        return $next($request);
    }
}
