<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Chats\Controllers\ChatController;
use Modules\Chats\Controllers\MessageController;
use Modules\Cities\Controllers\CitiesController;
use Modules\Likes\LikeController;
use Modules\Predictions\PredictionController;
use Modules\Support\SupportController;
use Modules\Users\Controllers\UserController;
use Modules\Users\Controllers\UserImageController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/check', [AuthController::class, 'check'])->name('auth.check');
});

// For authorized users
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'users'], function () {

        Route::get('/list', [UserController::class, 'getUsersList'])
            ->name('users.list');

        Route::post('/updateProperties', [UserController::class, 'updateProperties'])
            ->name('user.updateProperties');

        Route::post('/updateSettings', [UserController::class, 'updateSettings'])
            ->name('user.updateSettings');

        Route::post('/delete', [UserController::class, 'deleteUser'])
            ->name('user.deleteUser');

        Route::group(['prefix' => 'images'], function () {
            Route::post('/store', [UserImageController::class, 'store'])
                ->name('users.image.store');
        });

        Route::get('/me', [UserController::class, 'getCurrentUser'])
            ->name('user.self');
    });

    Route::group(['prefix' => 'likes'], function () {
        Route::post('/set', [LikeController::class, 'like'])
            ->name('like.set');

        Route::post('/revoke', [LikeController::class, 'revoke'])
            ->name('like.revoke');

        Route::post('/confirm', [LikeController::class, 'confirm'])
            ->name('like.confirm');

        Route::get('/list', [LikeController::class, 'likes'])
            ->name('likes.list');
    });

    Route::group(['prefix' => 'chats'], function () {

        Route::get('/list', [ChatController::class, 'list'])
            ->name('chats.list');

        Route::get('/chat', [ChatController::class, 'messages'])
            ->name('chat.messages');
    });

    Route::group(['prefix' => 'message'], function () {

        Route::post('/send', [MessageController::class, 'send'])
            ->name('message.send');
    });

    Route::get('/cities', [CitiesController::class, 'getCity'])
        ->name('cities.getCity');

    Route::group(['prefix' => 'prediction'], function () {
        Route::get('/get', [PredictionController::class, 'getPrediction'])
            ->name('prediction.get');
    });

    Route::group(['prefix' => 'support'], function () {
        Route::get('/create', [SupportController::class, 'create'])
            ->name('support.create');
    });
});
