<?php
declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\UserProperties;

class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Http\Response | array
    {
        $credentials = $request->validate(
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

        return ['id'=> $user->id];
    }

    public function getUserList()
    {
        //
    }

    public function getUserDetail(Request $request)
    {
        //
    }

    public function getCurrentUser(User $user)
    {
        //
    }

    public function updateUserProperty(Request $request, User $user)
    {
        //
    }

    public function storeUserProperties(Request $request, User $user)
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
