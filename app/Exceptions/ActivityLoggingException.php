<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Throwable;

class ActivityLoggingException extends AppException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = $previous instanceof Throwable ? $previous->getMessage() : 'Falha ao registrar atividade do ActivityLog';
        parent::__construct($message, 0, $previous);

        $this->statusCode = 200;
    }
}
