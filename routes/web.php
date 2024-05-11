<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/{any}', fn () => view('spa'))
    ->where('any', '.*')
    ->name('spa');
