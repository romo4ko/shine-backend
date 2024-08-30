<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Modules\Documents\DocumentController;

Route::get('/document/{slug}', [DocumentController::class, 'index'])
    ->name('document.show');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->name('verification.verify');

Route::get('/{any}', fn () => view('spa'))
    ->where('any', '.*')
    ->name('spa');
