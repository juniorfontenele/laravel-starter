<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;
use Throwable;

class AppException extends Exception
{
    public string $errorId;

    protected string $userMessage = 'Ocorreu um erro de aplicação. Tente novamente.';

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->errorId = Str::uuid()->toString();

        parent::__construct($message, $code, $previous);
    }

    public function userMessage(): string
    {
        return $this->userMessage . " (Erro: {$this->errorId})";
    }

    public function context(): array
    {
        return [
            'error_id' => $this->errorId,
            'exception' => static::class,
        ];
    }

    public function isRetryable(): bool
    {
        return true;
    }
}
