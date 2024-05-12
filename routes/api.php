<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Users\Controllers\UserController;
use Modules\Users\Properties\UserPropertiesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// For authorized users
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/list', [UserController::class, 'getUserList'])->name('users.list');
        Route::post('/storeProperties', [UserPropertiesController::class, 'storeUserProperties'])->name('users.store');
        Route::post('/updateProperties', [UserPropertiesController::class, 'updateUserProperties'])->name('users.update');
    });
});
