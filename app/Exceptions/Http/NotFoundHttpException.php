<?php

declare(strict_types = 1);

namespace App\Exceptions\Http;

use App\Exceptions\HttpException;
use Throwable;

class NotFoundHttpException extends HttpException
{
    public function __construct(string $message = '', public ?string $resource = null, ?Throwable $previous = null)
    {
        $this->userMessage = "O recurso não foi encontrado";

        $message = $message ?: "Recurso não encontrado";

        parent::__construct(404, $message, $resource, $previous);
    }
}
