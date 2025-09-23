<?php

declare(strict_types = 1);

use App\Filament\Admin\Resources\ActivityLogs\ActivityLogResource;
use App\Models\ActivityLog;
use App\Models\User;

it('cannot create new activity log from interface', function () {
    expect(ActivityLogResource::canCreate())->toBeFalse();
});

it('cannot edit activity log from interface', function () {
    $activityLog = ActivityLog::factory()->create();

    expect(ActivityLogResource::canEdit($activityLog))->toBeFalse();
});

it('cannot delete activity log from interface', function () {
    $activityLog = ActivityLog::factory()->create();

    expect(ActivityLogResource::canDelete($activityLog))->toBeFalse();
});

it('has correct resource configuration', function () {
    expect(ActivityLogResource::getModel())->toBe(ActivityLog::class);
    expect(ActivityLogResource::getRecordTitleAttribute())->toBe('action');
});

it('can get global search result details', function () {
    $user = User::factory()->create(['name' => 'Test User']);
    $activityLog = ActivityLog::factory()->create([
        'user_id' => $user->id,
        'action' => 'Test Action',
    ]);

    $details = ActivityLogResource::getGlobalSearchResultDetails($activityLog);

    expect($details)->toHaveKey('Ação');
    expect($details)->toHaveKey('Usuário');
    expect($details['Ação'])->toBe('Test Action');
    expect($details['Usuário'])->toBe('Test User');
});
