<?php

declare(strict_types = 1);

namespace App\Events\System;

use App\Events\AppEvent;

class ApplicationStarted extends AppEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(public string $host, public string $ip, public string $role)
    {
        //
    }

    /** @return array<string, mixed> */
    public function context(): array
    {
        return array_merge(parent::context(), [
            'host' => $this->host,
            'ip' => $this->ip,
            'role' => $this->role,
        ]);
    }
}
