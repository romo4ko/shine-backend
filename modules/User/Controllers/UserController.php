<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

    public function deleteUser(User $user)
    {
        $user = Auth::user();
    }
}
