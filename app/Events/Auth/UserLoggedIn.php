<?php

declare(strict_types = 1);

namespace App\Events\Auth;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Events\AppEvent;
use App\Models\User;

class UserLoggedIn extends AppEvent
{
    public string $name = 'User Logged In';

    public LogType $type = LogType::USER;

    public LogLevel $level = LogLevel::INFO;

    public ?string $description = 'Usuário autenticado no sistema';

    public function __construct(public User $user)
    {
        parent::__construct();
    }

    public function context(): array
    {
        return array_merge(parent::context(), [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'roles' => $this->user->roles->pluck('name')->toArray(),
            ],
        ]);
    }
}
