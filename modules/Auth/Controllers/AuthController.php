<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;

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
                'error' => 'Пользователя с такими данными не существует',
            ], 401);
        }

        return response([
            'user' => $user,
            'token' => $user->createToken('main')->plainTextToken,
        ]);
    }

    public function register(Request $request, Property $property): \Illuminate\Http\Response|array
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $birthdate = Carbon::createFromFormat('d.m.Y', $request->birthdate);
        $sign = null;
        foreach (config('properties.zodiac') as $zodiac) {

            $dateFrom = Carbon::createFromFormat('d.m', $zodiac['dates'][0]);
            $dateTo = Carbon::createFromFormat('d.m', $zodiac['dates'][1]);

            if ($birthdate->month == $dateFrom->month && $birthdate->day >= $dateFrom->day ||
                $birthdate->month == $dateTo->month && $birthdate->day <= $dateTo->day
            ) {
                $sign = $property->getId('zodiac', $zodiac['code']);
            }
        }

        $user->properties->update([
            'birthdate' => $birthdate,
            'sign' => $sign,
        ]);

        // TODO: Отправка письма для подтверждения

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

        return response([
            'user' => $user,
        ]);
    }
}
