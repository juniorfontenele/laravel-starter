<?php

declare(strict_types = 1);

namespace App\Exceptions\Http;

use App\Exceptions\HttpException;
use Throwable;

class UnauthorizedHttpException extends HttpException
{
    public function __construct(string $message = '', public ?string $resource = null, ?Throwable $previous = null)
    {
        $this->userMessage = "Acesso não autorizado. Por favor, faça login para continuar.";

        $message = $message ?: "Acesso não autorizado";

        parent::__construct(401, $message, $resource, $previous);
    }
}
