<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\User;
use Modules\Users\Resources\UserCollection;

class UserController extends Controller
{
    public function getUsersList(Request $request): UserCollection
    {
        $user = Auth::user();

        $count = config('settings.pagination.count');
        $page = $user->settings->page;
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $users = User::where('email', '!=', 'admin@admin.ru')->paginate($count);

        $lastPage = $users->lastPage();
        if ($page < $lastPage) {
            $user->settings->increment('page', 1);
        } else {
            $user->settings->update([
                'page' => 1,
            ]);
        }

        return (new UserCollection($users))
            ->additional([
                'meta' => [
                    'key' => 'value',
                ],
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
