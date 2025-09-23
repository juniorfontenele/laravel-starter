<?php

declare(strict_types = 1);

namespace App\Events\Auth;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Events\AppEvent;

class UserLoginFailed extends AppEvent
{
    public string $name = 'User Login Failed';

    public LogType $type = LogType::USER;

    public LogLevel $level = LogLevel::WARNING;

    public ?string $description = 'Tentativa de login falhou';

    public function __construct(
        public string $email,
        public ?string $reason = null
    ) {
        parent::__construct();
    }

    public function context(): array
    {
        return array_merge(parent::context(), [
            'email' => $this->email,
            'reason' => $this->reason,
        ]);
    }
}
