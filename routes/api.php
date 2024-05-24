<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Chats\Controllers\ChatController;
use Modules\Likes\LikeController;
use Modules\Users\Controllers\UserController;
use Modules\Users\Images\Controllers\UserImageController;
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
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/check', [AuthController::class, 'check'])->name('auth.check');
});

// For authorized users
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/list', [UserController::class, 'getUsersList'])->name('users.list');
        Route::post('/storeProperties', [UserPropertiesController::class, 'storeUserProperties'])->name('users.store');
        Route::post('/updateProperties', [UserPropertiesController::class, 'updateUserProperties'])->name('users.update');

        Route::group(['prefix' => 'images'], function () {
            Route::post('/store', [UserImageController::class, 'store'])->name('image.store');
        });
    });

    Route::group(['prefix' => 'likes'], function () {
        Route::post('/set', [LikeController::class, 'like'])->name('likes.set');
    });

    Route::group(['prefix' => 'chats'], function () {
        Route::get('/list', [ChatController::class, 'list'])->name('chats.list');
    });

});
