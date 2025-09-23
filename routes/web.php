<?php

declare(strict_types = 1);

use App\Http\Middleware\CheckTenantPermission;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('app/index');
})
    ->name('dashboard')
    ->middleware('auth', CheckTenantPermission::class);

require __DIR__ . '/auth.php';
