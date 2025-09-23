<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthenticateUserLoginRequest;
use App\Actions\Auth\Logout;
use App\Actions\Tenant\SetTenant;
use App\Exceptions\Tenant\TenantUnauthorizedException;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
        ]);
    }

    public function store(Request $request, SetTenant $setTenant)
    {
        $user = app(AuthenticateUserLoginRequest::class)->execute($request);

        if ($user->hasMultipleTenants()) {
            return redirect()->route('select-tenant');
        }

        $setTenant->execute($user->getTenantsForUser()->first()?->getKey());

        return redirect()->route('dashboard');
    }

    public function selectTenant(Request $request)
    {
        return Inertia::render('auth/select-tenant', [
            'tenants' => $request->user()?->getTenantsForUser(),
        ]);
    }

    public function setTenant(Request $request, SetTenant $setTenant)
    {
        $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
        ]);

        $tenant = Tenant::findOrFail($request->integer('tenant_id'));

        if ($request->user()?->cannot('access', $tenant)) {
            throw new TenantUnauthorizedException($tenant->id);
        }

        $setTenant->execute($request->integer('tenant_id'));

        $request->user()?->update(['last_tenant_id' => $tenant->id]);

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        app(Logout::class)->execute($request);

        return redirect('/');
    }
}
