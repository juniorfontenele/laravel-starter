<?php

declare(strict_types = 1);

namespace App\Events\Tenant;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Events\AppEvent;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class TenantSelectedByHost extends AppEvent
{
    public string $name = 'Tenant Selected by Host';

    public LogType $type = LogType::SYSTEM;

    public LogLevel $level = LogLevel::DEBUG;

    public ?string $description = 'Tenant selecionado automaticamente pelo host';

    public function __construct(
        public string $host,
        public Tenant $tenant,
    ) {
        parent::__construct();
    }

    public function subject(): ?Model
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
            'tenant' => [
                'id' => $this->tenant->id,
                'name' => $this->tenant->name,
                'is_active' => $this->tenant->is_active,
                'is_fallback' => $this->tenant->is_fallback,
                'host' => $this->host,
            ],
        ]);
    }
}
