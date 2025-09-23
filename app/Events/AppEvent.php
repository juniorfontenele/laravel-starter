<?php

declare(strict_types = 1);

namespace App\Events;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class AppEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public string $correlationId;

    public string $requestId;

    public LogLevel $level = LogLevel::INFO;

    public LogType $type = LogType::SYSTEM;

    public string $name = 'Generic Event';

    public ?string $description = null;

    public bool $shouldLog = true;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->correlationId = session()->get('correlation_id', (string) Str::uuid());
        $this->requestId = session()->get('request_id', (string) Str::uuid());
    }

    public function shouldLog(): bool
    {
        return $this->shouldLog;
    }

    public function causer(): ?User
    {
        return Auth::user();
    }

    public function tenant(): ?Tenant
    {
        return getCurrentTenant();
    }

    public function subject(): ?Model
    {
        return null;
    }

    public function context(): array
    {
        return [
            'correlation_id' => $this->correlationId,
            'request_id' => $this->requestId,
            'event' => [
                'class' => get_class($this),
                'name' => $this->name,
                'description' => $this->description,
                'level' => $this->level->value,
                'type' => $this->type->value,
            ],
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
