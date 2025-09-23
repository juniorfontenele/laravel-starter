<?php

declare(strict_types = 1);

namespace App\Exceptions\Tenant;

use App\Exceptions\AppException;
use Throwable;

class TenantException extends AppException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->userMessage = 'Ocorreu um erro relacionado ao tenant.';

        parent::__construct($message, $code, $previous);
    }
}
