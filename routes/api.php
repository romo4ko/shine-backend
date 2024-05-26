<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Chats\Controllers\ChatController;
use Modules\Chats\Controllers\MessageController;
use Modules\Likes\LikeController;
use Modules\Users\Controllers\UserController;
use Modules\Users\Controllers\UserImageController;
use Modules\Users\Controllers\UserPropertiesController;

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
        Route::post('/updateProperties', [UserPropertiesController::class, 'updateUserProperties'])->name('user.update');

        Route::group(['prefix' => 'images'], function () {
            Route::post('/store', [UserImageController::class, 'store'])->name('image.store');
        });

        Route::get('/me', [UserController::class, 'getCurrentUser'])->name('user.self');
    });

    Route::group(['prefix' => 'likes'], function () {
        Route::post('/set', [LikeController::class, 'like'])->name('like.set');
    });

    Route::group(['prefix' => 'chats'], function () {
        Route::get('/list', [ChatController::class, 'list'])->name('chats.list');
        Route::get('/chat', [ChatController::class, 'messages'])->name('chat.messages');
    });

    Route::group(['prefix' => 'message'], function () {
        Route::post('/send', [MessageController::class, 'send'])->name('message.send');
    });
});
