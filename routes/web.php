<?php

use ErfanMasboogh\Laran\Http\Controllers\Web\AuthController;
use ErfanMasboogh\Laran\Http\Controllers\Web\DashboardController;
use ErfanMasboogh\Laran\Http\Controllers\Web\ManagerController;
use ErfanMasboogh\Laran\Http\Controllers\Web\StorageController;
use ErfanMasboogh\Laran\Middleware\AuthenticateManager;
use ErfanMasboogh\Laran\Middleware\RedirectIfManagerAuthenticated;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('web')->group(function () {
    // Routes without auth
    Route::middleware(RedirectIfManagerAuthenticated::class)->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('admin.login');
        Route::post('loginCheck', [AuthController::class, 'loginCheck'])->name('admin.loginCheck');
    });
    // Routes with auth
    Route::middleware(AuthenticateManager::class)->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::group(['prefix' => 'manager'], function () {
            Route::get('/list', [ManagerController::class, 'list'])->name('admin.manager.list');
            Route::get('/create', [ManagerController::class, 'create'])->name('admin.manager.create');
            Route::post('/store', [ManagerController::class, 'store'])->name('admin.manager.store');
            Route::get('/edit/{manager}', [ManagerController::class, 'edit'])->name('admin.manager.edit');
            Route::post('/update/{manager}', [ManagerController::class, 'update'])->name('admin.manager.update');
        });

    });
});

// Storage
Route::get('/storage/download/{sid}', [StorageController::class, 'download'])->middleware('web')->name(
    'storage.download'
);

