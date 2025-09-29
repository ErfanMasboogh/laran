<?php

use Illuminate\Support\Facades\Route;
use ErfanMasboogh\Laran\Http\Controllers\Web\AuthController;
use ErfanMasboogh\Laran\Http\Controllers\Web\DashboardController;
use ErfanMasboogh\Laran\Middleware\AuthenticateManager;
use ErfanMasboogh\Laran\Middleware\RedirectIfManagerAuthenticated;

Route::prefix('admin')->middleware('web')->group(function () {
    Route::middleware(RedirectIfManagerAuthenticated::class)->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('admin.login');
        Route::post('loginCheck', [AuthController::class, 'loginCheck'])->name('admin.loginCheck');
    });
    Route::middleware(AuthenticateManager::class)->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
        // Test
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    });
});

