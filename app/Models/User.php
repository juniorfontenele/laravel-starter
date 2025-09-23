<?php

declare(strict_types = 1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasActiveState;
use App\Traits\HasActor;
use Filament\Panel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasActiveState;
    use HasActor;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_global_admin' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, 'user_tenant')
            ->withTimestamps();
    }

    public function lastTenant(): HasOne
    {
        return $this->hasOne(Tenant::class, 'id', 'last_tenant_id');
    }

    public function isGlobalAdmin(): bool
    {
        return $this->is_global_admin;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isGlobalAdmin()
            && $this->isActive()
            && $this->hasVerifiedEmail();
    }

    public function hasMultipleTenants(): bool
    {
        return ($this->isGlobalAdmin() && Tenant::count() > 1)
            || $this->tenants->count() > 1;
    }

    public function getTenantsForUser(): Collection
    {
        if ($this->isGlobalAdmin()) {
            return Tenant::all();
        }

        return $this->tenants;
    }
}
