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

        return TenantHost::where('host', $host)->first()?->tenant
            ?? Tenant::where('is_fallback', true)->first()
            ?? throw new TenantNotFoundException($host);
    }
}
