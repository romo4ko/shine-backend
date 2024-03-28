<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');

    // For authorized users
    Route::group(['middleware' => 'auth'], function () {
        // Роуты для авторизованных
    });
});

Route::get('/{any}', fn() => view('spa'))
    ->where('any', '.*')
    ->name('spa');
