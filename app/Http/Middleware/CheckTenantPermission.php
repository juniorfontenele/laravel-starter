<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Exceptions\Tenant\TenantUnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = session()->get('tenant');

        if (! $tenant) {
            return redirect()->route('select-tenant');
        }

        if ($request->user()?->cannot('access', $tenant)) {
            throw new TenantUnauthorizedException($tenant->id);
        }

        return $next($request);
    }
}
