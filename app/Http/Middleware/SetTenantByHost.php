<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Actions\Tenant\SetTenantForHost;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenantByHost
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        setPermissionsTeamId(null);

        $host = $request->getHost();

        app(SetTenantForHost::class)->execute($host);

        return $next($request);
    }
}
