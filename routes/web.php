<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use ErfanMasboogh\Laran\Http\Controllers\Web\AuthController;

Route::prefix('admin')->group(function () {
    Route::middleware('guest', 'web')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('admin.login');
        Route::post('loginCheck', [AuthController::class, 'loginCheck'])->name('admin.loginCheck');
    });
});

