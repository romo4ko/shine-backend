<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/auth/register',
        'api/auth/login',
        'api/auth/logout',
        'api/users/storeUserProperties',
        'api/users/updateUserProperties',
    ];
}
