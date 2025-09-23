<?php

declare(strict_types = 1);

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'global-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'admin-readonly']);
        Role::create(['name' => 'user']);

        Tenant::all()->each(function (Tenant $tenant): void {
            User::query()->where('is_global_admin', true)->get()?->each(function (User $user) use ($tenant): void {
                setPermissionsTeamId($tenant->id);

                $user->assignRole('global-admin');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
