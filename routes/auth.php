<?php

declare(strict_types = 1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\SetTenantByHost;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', SetTenantByHost::class])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('select-tenant', [AuthenticatedSessionController::class, 'selectTenant'])
        ->name('select-tenant');

    Route::post('select-tenant', [AuthenticatedSessionController::class, 'setTenant'])
        ->name('select-tenant.store');
});
