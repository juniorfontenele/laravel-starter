<?php

declare(strict_types = 1);

namespace App\Exceptions;

use App\Actions\System\NotifyExceptionAction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class AppException extends Exception
{
    public string $errorId;

    public int $statusCode = 500;

    public string $userMessage = 'Ocorreu um erro de aplicação. Tente novamente.';

    public function __construct(string $message = '', $code = 0, ?Throwable $previous = null)
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
        $user = Auth::user()?->only(['id', 'name', 'email']);
        $roles = Auth::user()?->roles?->pluck('name')?->toArray();

        return [
            'resource' => request()->getRequestUri(),
            'status_code' => $this->statusCode,
            'error_id' => $this->errorId,
            'correlation_id' => session()->get('correlation_id'),
            'request_id' => session()->get('request_id'),
            'user' => [
                'id' => $user['id'] ?? null,
                'name' => $user['name'] ?? null,
                'email' => $user['email'] ?? null,
                'roles' => $roles,
            ],
            'actual_exception' => [
                'class' => get_class($this),
                'message' => $this->getMessage(),
                'file' => $this->getFile(),
                'line' => $this->getLine(),
                'code' => $this->getCode(),
            ],
            'previous_exception' => $this->getPrevious() instanceof Throwable ? [
                'class' => get_class($this->getPrevious()),
                'message' => $this->getPrevious()->getMessage(),
                'file' => $this->getPrevious()->getFile(),
                'line' => $this->getPrevious()->getLine(),
                'code' => $this->getPrevious()->getCode(),
            ] : null,
        ];
    }

    public function isRetryable(): bool
    {
        return true;
    }

    public function render()
    {
        return response()->view('errors.app', [
            'code' => $this->errorId,
            'message' => $this->userMessage,
        ], $this->statusCode);
    }

    public function report(NotifyExceptionAction $notifyExceptionAction)
    {
        $notifyExceptionAction->execute($this);

        return false;
    }
}
