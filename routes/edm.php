<?php

use App\Http\Controllers\Superadmin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('edm')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/branch', [DashboardController::class, 'showBranch'])
            ->name('edm.branch');

        Route::get('/division', [DashboardController::class, 'showDivision'])
            ->name('edm.division');
    });
