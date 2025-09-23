<?php

declare(strict_types = 1);

use App\Enums\LogLevel;
use App\Models\ActivityLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->tenant = Tenant::factory()->create();
});

it('creates activity log with basic action', function () {
    $log = activity('user_logged_in')
        ->by($this->user)
        ->onTenant($this->tenant)
        ->log();

    expect($log)
        ->toBeInstanceOf(ActivityLog::class)
        ->and($log->action)->toBe('user_logged_in')
        ->and($log->user_id)->toBe($this->user->id)
        ->and($log->tenant_id)->toBe($this->tenant->id)
        ->and($log->level)->toBe(LogLevel::INFO);
});

it('creates activity log with subject', function () {
    $subject = User::factory()->create();

    $log = activity('user_updated')
        ->by($this->user)
        ->onTenant($this->tenant)
        ->on($subject)
        ->withDescription('User profile updated')
        ->log();

    expect($log->subject_type)->toBe(User::class)
        ->and($log->subject_id)->toBe($subject->id)
        ->and($log->description)->toBe('User profile updated');
});

it('creates activity log with metadata', function () {
    $metadata = ['old_email' => 'old@example.com', 'new_email' => 'new@example.com'];

    $log = activity('email_changed')
        ->by($this->user)
        ->onTenant($this->tenant)
        ->withMetadata($metadata)
        ->log();

    expect($log->metadata)->toBe($metadata);
});

it('sets different log levels', function () {
    $log = activity('critical_error')
        ->by($this->user)
        ->onTenant($this->tenant)
        ->critical()
        ->log();

    expect($log->level)->toBe(LogLevel::CRITICAL);
});

it('allows nullable user', function () {
    $log = activity('system_action')
        ->onTenant($this->tenant)
        ->withDescription('Automated system action')
        ->log();

    expect($log->user_id)->toBeNull()
        ->and($log->tenant_id)->toBe($this->tenant->id)
        ->and($log->action)->toBe('system_action');
});

it('allows nullable tenant', function () {
    $log = activity('global_action')
        ->by($this->user)
        ->withDescription('Global system action')
        ->log();

    expect($log->user_id)->toBe($this->user->id)
        ->and($log->tenant_id)->toBeNull()
        ->and($log->action)->toBe('global_action');
});

it('allows both user and tenant to be null', function () {
    $log = activity('anonymous_action')
        ->withDescription('Anonymous action logged')
        ->debug()
        ->log();

    expect($log->user_id)->toBeNull()
        ->and($log->tenant_id)->toBeNull()
        ->and($log->action)->toBe('anonymous_action')
        ->and($log->level)->toBe(LogLevel::DEBUG);
});

it('automatically detects authenticated user and session tenant', function () {
    // Simular usuário autenticado
    $this->actingAs($this->user);

    // Simular tenant na sessão
    session(['tenant' => $this->tenant]);

    $log = activity('auto_detected_action')
        ->withDescription('Action with automatic user and tenant detection')
        ->log();

    expect($log->user_id)->toBe($this->user->id)
        ->and($log->tenant_id)->toBe($this->tenant->id)
        ->and($log->action)->toBe('auto_detected_action')
        ->and($log->description)->toBe('Action with automatic user and tenant detection');
});

it('automatically detects only authenticated user when no tenant in session', function () {
    // Simular usuário autenticado sem tenant na sessão
    $this->actingAs($this->user);
    session()->forget('tenant');

    $log = activity('user_only_auto_detected')
        ->withDescription('Action with only user auto-detection')
        ->log();

    expect($log->user_id)->toBe($this->user->id)
        ->and($log->tenant_id)->toBeNull()
        ->and($log->action)->toBe('user_only_auto_detected');
});

it('automatically detects only session tenant when no authenticated user', function () {
    // Simular tenant na sessão sem usuário autenticado
    session(['tenant' => $this->tenant]);
    Auth::logout();

    $log = activity('tenant_only_auto_detected')
        ->withDescription('Action with only tenant auto-detection')
        ->log();

    expect($log->user_id)->toBeNull()
        ->and($log->tenant_id)->toBe($this->tenant->id)
        ->and($log->action)->toBe('tenant_only_auto_detected');
});

it('automatically detects tenant when passed as integer ID', function () {
    $this->actingAs($this->user);

    $log = activity('tenant_id_auto_detected')
        ->onTenant($this->tenant->id)
        ->withDescription('Action with tenant ID auto-detection')
        ->log();

    expect($log->user_id)->toBe($this->user->id)
        ->and($log->tenant_id)->toBe($this->tenant->id)
        ->and($log->action)->toBe('tenant_id_auto_detected');
});

it('automatically detects user when passed as integer ID', function () {
    $log = activity('user_id_auto_detected')
        ->by($this->user->id)
        ->withDescription('Action with user ID auto-detection')
        ->log();

    expect($log->user_id)->toBe($this->user->id)
        ->and($log->action)->toBe('user_id_auto_detected');
});
