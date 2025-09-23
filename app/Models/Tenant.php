<?php

declare(strict_types = 1);

namespace App\Models;

use App\Traits\HasActiveState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory;
    use HasActiveState;

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_fallback' => 'boolean',
        ];
    }

    public function hosts(): HasMany
    {
        return $this->hasMany(TenantHost::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_tenant')
            ->withTimestamps();
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
