<?php

declare(strict_types = 1);

namespace App\Services;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Exceptions\ActivityLoggingException;
use App\Models\ActivityLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    protected string $action;

    protected LogLevel $level = LogLevel::INFO;

    protected LogType $type = LogType::USER;

    protected ?string $description = null;

    protected array $metadata = [];

    protected User|int|null $user = null;

    protected Tenant|int|null $tenant = null;

    protected Model|null $subject = null;

    public function __construct(string $action)
    {
        $this->action = $action;
        $this->setDefaultUser();
        $this->setDefaultTenant();
    }

    public function by(User|int|null $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function causedBy(User|int|null $user): self
    {
        return $this->by($user);
    }

    public function performedOn(?Model $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function on(?Model $subject): self
    {
        return $this->performedOn($subject);
    }

    public function onTenant(Tenant|int|null $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function tenant(Tenant|int|null $tenant): self
    {
        return $this->onTenant($tenant);
    }

    public function withDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function withMetadata(array $metadata): self
    {
        $this->metadata = array_merge($this->metadata, $metadata);

        return $this;
    }

    public function withProperty(string $key, mixed $value): self
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    public function withProperties(array $properties): self
    {
        return $this->withMetadata($properties);
    }

    public function type(LogType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function level(LogLevel $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function debug(): self
    {
        return $this->level(LogLevel::DEBUG);
    }

    public function info(): self
    {
        return $this->level(LogLevel::INFO);
    }

    public function notice(): self
    {
        return $this->level(LogLevel::NOTICE);
    }

    public function warning(): self
    {
        return $this->level(LogLevel::WARNING);
    }

    public function error(): self
    {
        return $this->level(LogLevel::ERROR);
    }

    public function critical(): self
    {
        return $this->level(LogLevel::CRITICAL);
    }

    public function alert(): self
    {
        return $this->level(LogLevel::ALERT);
    }

    public function emergency(): self
    {
        return $this->level(LogLevel::EMERGENCY);
    }

    public function log(): ?ActivityLog
    {
        try {
            $userId = $this->resolveUserId();
            $tenantId = $this->resolveTenantId();

            return ActivityLog::create([
                'user_id' => $userId,
                'tenant_id' => $tenantId,
                'subject_type' => $this->subject?->getMorphClass(),
                'subject_id' => $this->subject?->getKey(),
                'level' => $this->level,
                'type' => $this->type,
                'action' => $this->action,
                'description' => $this->description,
                'metadata' => $this->metadata ?: null,
            ]);
        } catch (\Throwable $e) {
            report(new ActivityLoggingException($e));

            return null;
        }
    }

    protected function setDefaultUser(): void
    {
        if (Auth::check()) {
            $this->user = Auth::user();
        }
    }

    protected function setDefaultTenant(): void
    {
        $tenant = getCurrentTenant();

        if (! is_null($tenant)) {
            if ($tenant instanceof Tenant) {
                $this->tenant = $tenant;
            } elseif (is_numeric($tenant)) {
                $this->tenant = (int) $tenant;
            }
        }
    }

    protected function resolveUserId(): ?int
    {
        if ($this->user instanceof User) {
            return $this->user->id;
        }

        if (is_int($this->user)) {
            return $this->user;
        }

        return null;
    }

    protected function resolveTenantId(): ?int
    {
        if ($this->tenant instanceof Tenant) {
            return $this->tenant->id;
        }

        if (is_int($this->tenant)) {
            return $this->tenant;
        }

        return null;
    }
}
