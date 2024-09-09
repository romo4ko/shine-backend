<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Email\EmailConfirmToken;
use Modules\Users\Models\User;
use Modules\Users\Zodiac;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\Response|array
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'error' => config('messages.error.auth.not_found'),
            ]);
        } else {
            $user->login_at = Carbon::now();
            $user->save();
        }

        if (is_null($user->properties->name) ||
            is_null($user->properties->gender) ||
            is_null($user->properties->purpose)
            // is_null($user->city) ||
        ) {
            return response([
                'user' => $user,
                'token' => $user->createToken('main')->plainTextToken,
                'filled' => false,
            ]);
        }

        return response([
            'user' => $user,
            'token' => $user->createToken('main')->plainTextToken,
        ]);
    }

    public function register(Request $request, Zodiac $zodiac): \Illuminate\Http\Response|array
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if (User::where('email', $request->email)->first() != null) {
            return response([
                'error' => config('messages.error.auth.exists'),
            ]);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'login_at' => Carbon::now(),
        ]);

        $birthdate = Carbon::createFromFormat('d.m.Y', $request->birthdate);
        $sign = $zodiac->getSignByDate($birthdate);

        $user->properties->update([
            'birthdate' => $birthdate,
            'sign' => $sign->id,
        ]);

        $emailCheckToken = Str::random(30);
        EmailConfirmToken::create([
            'user_id' => $user->id,
            'token' => $emailCheckToken,
        ]);

        Mail::to($user->email)
            ->locale('ru')
            ->send(new VerifyEmail($user, $emailCheckToken));

        return response([
            'user' => $user,
            'token' => $user->createToken('main')->plainTextToken,
        ]);
    }

    public function logout(): \Illuminate\Http\Response|array
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return response([
            'success' => true,
        ]);
    }

    public function check(): \Illuminate\Http\Response|array
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return response([
                'error' => config('messages.error.auth.unauthorized'),
            ]);
        }

        $filled = null;
        if ($user->properties->purpose === null) {
            $filled = 'purpose';
        } elseif ($user->properties->name === null) {
            $filled = 'info';
        }

        return response([
            'user' => [
                ...$user->toArray(),
                'is_premium' => false,
            ],
            'filled' => $filled,
        ]);
    }
}
