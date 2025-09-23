<?php

declare(strict_types = 1);

namespace App\Actions\System;

use App\Exceptions\AppException;
use App\Models\Exception;
use Illuminate\Support\Facades\Auth;

class NotifyExceptionAction
{
    public function execute(AppException $exception): void
    {
        try {
            Exception::create([
                'exception_class' => get_class($exception),
                'message' => $exception->getMessage(),
                'user_message' => $exception->userMessage,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode(),
                'status_code' => $exception->statusCode,
                'error_id' => $exception->errorId,
                'correlation_id' => session()->get('correlation_id'),
                'request_id' => session()->get('request_id'),
                'app_version' => config('app.version'),
                'user_id' => Auth::id(),
                'tenant_id' => session()->get('tenant')?->id,
                'is_retryable' => $exception->isRetryable(),
                'stack_trace' => $exception->getTraceAsString(),
                'context' => $exception->context(),
                'previous_exception_class' => $exception->getPrevious() ? get_class($exception->getPrevious()) : null,
                'previous_message' => $exception->getPrevious()?->getMessage(),
                'previous_file' => $exception->getPrevious()?->getFile(),
                'previous_line' => $exception->getPrevious()?->getLine(),
                'previous_code' => $exception->getPrevious()?->getCode(),
                'previous_stack_trace' => $exception->getPrevious()?->getTraceAsString(),
            ]);
        } catch (\Throwable) {
            // Do nothing
        }
    }
}
