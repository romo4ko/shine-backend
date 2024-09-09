<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Documents\DocumentController;
use Modules\Email\EmailController;

Route::get('/document/{slug}', [DocumentController::class, 'index'])
    ->name('document.show');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::group(['prefix' => 'email'], function () {
    Route::get('/verify/{user_id}/{token}', [EmailController::class, 'verify'])
        ->name('email.verify');
});

Route::get('/{any}', fn () => view('spa'))
    ->where('any', '.*')
    ->name('spa');
