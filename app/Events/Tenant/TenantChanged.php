<?php

declare(strict_types = 1);

namespace App\Events\Tenant;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Events\AppEvent;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TenantChanged extends AppEvent
{
    public string $name = 'Tenant Changed';

    public LogType $type = LogType::USER;

    public LogLevel $level = LogLevel::NOTICE;

    public ?string $description = 'Usuário trocou de tenant';

    public function __construct(
        public User $user,
        public Tenant $newTenant,
        public Tenant $previousTenant
    ) {
        parent::__construct();
    }

    public function subject(): ?Model
    {
        return $this->newTenant;
    }

    public function tenant(): ?Tenant
    {
        return $this->previousTenant;
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
            'new_tenant' => [
                'id' => $this->newTenant->id,
                'name' => $this->newTenant->name,
                'is_active' => $this->newTenant->is_active,
                'is_fallback' => $this->newTenant->is_fallback,
            ],
            'previous_tenant' => [
                'id' => $this->previousTenant->id,
                'name' => $this->previousTenant->name,
                'is_active' => $this->previousTenant->is_active,
                'is_fallback' => $this->previousTenant->is_fallback,
            ],
        ]);
    }
}
