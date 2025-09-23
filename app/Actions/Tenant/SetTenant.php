<?php

declare(strict_types = 1);

namespace App\Actions\Tenant;

use App\Events\Tenant\TenantChanged;
use App\Events\Tenant\TenantSelected;
use App\Exceptions\Tenant\TenantException;
use App\Models\Tenant;

class SetTenant
{
    public function execute(int $tenantId): void
    {
        $oldTenant = session('tenant');

        $tenant = Tenant::find($tenantId) ?? throw new TenantException("Tenant com ID {$tenantId} não encontrado.");

        session(['tenant' => $tenant]);

        setPermissionsTeamId($tenant->id);

        request()->user()?->unsetRelation('roles')?->unsetRelation('permissions');

        if ($oldTenant && $oldTenant->id !== $tenant->id) {
            event(new TenantChanged(request()->user(), $tenant, $oldTenant));
        } else {
            event(new TenantSelected(request()->user(), $tenant));
        }
    }
}
