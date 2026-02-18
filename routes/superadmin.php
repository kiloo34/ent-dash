<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super-admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Superadmin\DashboardController::class, 'show'])
            ->name('dashboard');

        // Security
        Route::get('/roles', \App\Livewire\Admin\Security\RoleList::class)->name('roles.index');
        Route::get('/permissions', \App\Livewire\Admin\Security\PermissionList::class)->name('permissions.index');

        Route::get('/manage-users', function () {
            return 'Manage Users Page';
        })->middleware('permission:manage-user')
          ->name('manage-users');

        Route::get('/activity-logs', \App\Livewire\Admin\ActivityLog::class)
          ->name('activity-logs');

        Route::prefix('organization')->name('organization.')->group(function () {
            Route::get('/units', \App\Livewire\Admin\Organization\UnitList::class)->name('units');
            Route::get('/positions', \App\Livewire\Admin\Organization\PositionList::class)->name('positions');
        });

});
