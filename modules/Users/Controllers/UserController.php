<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Modules\Users\Properties\UserPropertiesController;
use Modules\Users\Resources\UserCollection;
use Modules\Users\Resources\UserResource;
use Carbon\Carbon;
use Modules\Users\Models\User;
use Illuminate\Http\Request;
use Modules\Users\Properties\Models\UserProperties;

class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Http\Response | array
    {
        $request->validate(
            [
                'email'     => ['required', 'email'],
                'password'  => ['required'],
                'birthdate' => ['required']
            ]
        );

        $user = User::create([
            'email'     => $request->email,
            'password'  => $request->password,
        ]);

        UserProperties::create([
            'user_id' => $user->id,
            'birthdate' => Carbon::parse($request->birthdate)->format('Y-m-d')
        ]);

        // TODO: Отправка письма для подтверждения

        return ['id' => $user->id];
    }

    public function getUserList(): UserCollection
    {
        $users = User::paginate(10);
        return (new UserCollection($users))
            ->additional([
                'meta' => [
                    'key' => 'value',
                ]
            ]);
    }

    public function getUserDetail(Request $request, User $user)
    {
        //
    }

    public function getCurrentUser(User $user)
    {
        //
    }

    public function updateUserSetting(Request $request, User $user)
    {
        //
    }

    public function deleteUser()
    {
        //
    }
}
