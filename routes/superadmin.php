<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super-admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('superadmin.dashboard');
        })->name('dashboard');

        Route::get('/manage-users', function () {
            return 'Manage Users Page';
        })->middleware('permission:manage-user')
          ->name('manage-users');

});
