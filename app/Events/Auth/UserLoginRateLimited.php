<?php

declare(strict_types = 1);

namespace App\Events\Auth;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Events\AppEvent;

class UserLoginRateLimited extends AppEvent
{
    public string $name = 'User Login Rate Limited';

    public LogType $type = LogType::USER;

    public LogLevel $level = LogLevel::WARNING;

    public ?string $description = 'Tentativa de login bloqueada por excesso de tentativas';

    public function __construct(
        public string $email,
        public int $maxAttempts,
        public int $availableInSeconds,
        public ?string $reason = null
    ) {
        parent::__construct();
    }

    public function context(): array
    {
        return array_merge(parent::context(), [
            'email' => $this->email,
            'max_attempts' => $this->maxAttempts,
            'available_in_seconds' => $this->availableInSeconds,
            'reason' => $this->reason,
        ]);
    }
}
