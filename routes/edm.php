<?php

use App\Http\Controllers\Superadmin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('edm')
    ->middleware(['auth'])
    ->group(function () {
        // Transaction routes removed
    });
