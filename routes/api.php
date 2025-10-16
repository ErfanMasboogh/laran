<?php

use ErfanMasboogh\Laran\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('v1')->group(function () {

        // Auth
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/register', [AuthController::class, 'register'])->name('v1.auth.register');
        });

    });
});
