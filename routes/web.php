<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Users\Controllers\UserController;
use Modules\Users\Properties\UserPropertiesController;

Route::group(['prefix' => 'api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    // For authorized users
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/list', [UserController::class, 'getUserList'])->name('users.list');
            Route::post('/storeUserProperties', [UserPropertiesController::class, 'storeUserProperties'])->name('users.store');
            Route::post('/updateUserProperties', [UserPropertiesController::class, 'updateUserProperties'])->name('users.update');
        });
    });
});

Route::get('/{any}', fn () => view('spa'))
    ->where('any', '.*')
    ->name('spa');
