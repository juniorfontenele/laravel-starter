<?php

declare(strict_types = 1);

namespace App\Actions\Tenant;

use App\Exceptions\Tenant\TenantNotFoundException;
use App\Models\Tenant;
use App\Models\TenantHost;

class GetTenantForHost
{
    public function execute(string $host): Tenant
    {
        $host = strtolower($host);

        /** @var Tenant|null $tenant */
        $tenant = TenantHost::query()->where('host', $host)->first()?->tenant;

        if ($tenant) {
            return $tenant;
        }

        $tenantFallback = Tenant::query()->where('is_fallback', true)->first();

        if ($tenantFallback) {
            return $tenantFallback;
        }

        throw new TenantNotFoundException($host);
    }
}
