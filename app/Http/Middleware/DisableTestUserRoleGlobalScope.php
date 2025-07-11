<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Scopes\UserRoleScope;
use App\Models\Test;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableTestUserRoleGlobalScope
{
    public function handle(Request $request, Closure $next): Response
    {

        Test::disableGlobalScope(UserRoleScope::class);

        return $next($request);
    }
}
