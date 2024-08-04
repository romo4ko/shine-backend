<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Documents\DocumentController;

Route::get('/document/{slug}', [DocumentController::class, 'index'])
    ->name('document.show');

Route::get('/{any}', fn () => view('spa'))
    ->where('any', '.*')
    ->name('spa');
