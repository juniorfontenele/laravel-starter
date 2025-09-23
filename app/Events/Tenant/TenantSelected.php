<?php

declare(strict_types = 1);

namespace App\Events\Tenant;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Events\AppEvent;
use App\Models\Tenant;
use App\Models\User;

class TenantSelected extends AppEvent
{
    public string $name = 'Tenant Selected';

    public LogType $type = LogType::USER;

    public LogLevel $level = LogLevel::DEBUG;

    public ?string $description = 'Usuário selecionou um tenant';

    public function __construct(
        public User $user,
        public Tenant $tenant
    ) {
        parent::__construct();
    }

    public function subject(): ?Tenant
    {
        return $this->tenant;
    }

    public function tenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function context(): array
    {
        return array_merge(parent::context(), [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'roles' => $this->user->roles?->pluck('name')->toArray(),
            ],
            'tenant' => [
                'id' => $this->tenant->id,
                'name' => $this->tenant->name,
                'is_active' => $this->tenant->is_active,
                'is_fallback' => $this->tenant->is_fallback,
            ],
        ]);
    }
}
