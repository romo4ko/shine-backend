<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Modules\Users\Models\User;
use Modules\Users\Properties\Models\UserProperties;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\Response | array
    {
        $credentials = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if (Auth::attempt($credentials, (bool) $request->input('remember') || true)) {
            $request->session()->regenerate();
            return ['id' => Auth::user()->id];
        } else {
            return Response::make(['message' => __('auth.failed')], 401);
        }
    }

    public function register(Request $request): \Illuminate\Http\Response | array
    {
        $credentials = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        $user = User::query()->create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->properties->update([
            'birthdate' => Carbon::parse($request->birtdate),
        ]);

        if (Auth::attempt($credentials, (bool) $request->input('remember') || true)) {
            $request->session()->regenerate();
            return ['id' => Auth::user()->id];
        } else {
            return Response::make(['message' => __('auth.failed')], 401);
        }
    }

    public function getCurrentAuth(): array
    {
        $user = Auth::user();
        if ($user) {
            return ['id' => $user->id, 'name' => $user->name, 'email' => $user->email];
        }
        return ['id' => null];
    }

    public function logout(): array
    {
        Auth::logout();
        return ['status' => 0];
    }
}
