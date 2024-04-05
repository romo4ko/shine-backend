<?php
declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function deleteUser()
    {
        //
    }
}
