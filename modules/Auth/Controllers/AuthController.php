<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Modules\Users\Models\User;
use Modules\Users\Properties\Models\UserProperties;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\Response | array
    {
        $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'error' => 'Пользователя с такими данными не существует',
            ]);
        }

        return response([
            'user' => $user,
            'token' => $user->createToken('main')->plainTextToken
        ]);
    }

    public function register(Request $request): \Illuminate\Http\Response | array
    {
        $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->properties->update([
            'birthdate' => Carbon::parse($request->birtdate),
        ]);

        return response([
            'user' => $user,
            'token' => $user->createToken('main')->plainTextToken
        ]);
    }

    public function logout(): \Illuminate\Http\Response | array
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return response([
            'success' => true
        ]);
    }
}
