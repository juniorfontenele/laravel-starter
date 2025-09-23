<?php

declare(strict_types = 1);

namespace App\Exceptions\Tenant;

use App\Exceptions\AppException;

class TenantNotFoundException extends AppException
{
    public int $statusCode = 404;

    public function __construct(public string $host)
    {
        $this->userMessage = "Falha ao acessar o tenant.";

        parent::__construct($this->userMessage, 404);
    }

    public function context(): array
    {
        return array_merge(parent::context(), [
            'host' => $this->host,
        ]);
    }
}
