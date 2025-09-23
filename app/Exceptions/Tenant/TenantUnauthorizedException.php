<?php

declare(strict_types = 1);

namespace App\Exceptions\Tenant;

use App\Exceptions\AppException;

class TenantUnauthorizedException extends AppException
{
    public int $statusCode = 404;

    public function __construct(public int $tenantId)
    {
        $this->userMessage = __("Falha ao acessar o tenant.");

        parent::__construct($this->userMessage, 403);
    }

    public function context(): array
    {
        return array_merge(parent::context(), [
            'tenant_id' => $this->tenantId,
        ]);
    }
}
