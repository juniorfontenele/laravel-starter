<?php

declare(strict_types = 1);

namespace App\Actions\Tenant;

use App\Events\Tenant\TenantSelectedByHost;

class SetTenantForHost
{
    public function __construct(public GetTenantForHost $getTenantForHost)
    {
        //
    }

    public function execute(string $host): void
    {
        $tenant = $this->getTenantForHost->execute($host);

        session(['tenant' => $tenant]);

        setPermissionsTeamId($tenant->id);

        request()->user()?->unsetRelation('roles')?->unsetRelation('permissions');

        event(new TenantSelectedByHost($host, $tenant));
    }
}
