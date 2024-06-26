<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Models\UserProperties;
use Modules\Users\Models\UserSettings;
use Modules\Users\Resources\UserCollection;
use Modules\Users\Resources\UserResource;

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

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

    // Store or update any user properties
    public function updateProperties(Request $request, Property $property, City $city): array
    {
        $relatedProperties = [
            'gender',
            'fs',
            'purpose',
            'children',
            'smoking',
            'alcohol',
            'education',
        ];
        if ($request->hasAny($relatedProperties)) {
            foreach ($request->only($relatedProperties) as $type => $code) {
                if ($code != null) {
                    UserProperties::where('user_id', $this->user->id)
                        ->update([
                            $type => $property->getId($type, $code),
                        ]);
                }
            }
        }
        if ($request->has('birthdate')) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    [
                        'birthdate' => Carbon::parse($request->birthdate),
                    ]
                );
        }
        if ($request->has('city') && $request->city != null) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    [
                        'city' => $city->getIdByName($request->city),
                    ]
                );
        }
        if ($request->hasAny(['text', 'name', 'height'])) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    $request->only(['text', 'name', 'height'])
                );
        }

        // TODO: add sign

        return [
            'status' => 'success',
        ];
    }

    public function updateSettings(Request $request, UserSettings $settings, Property $property): array
    {
        if ($request->hasAny('active')) {
            $settings->where('user_id', $this->user->id)
                ->update([
                    'active' => $request->active ? 1 : 0,
                ]);
        }

        if ($request->hasAny('bot_settings')) {
            $settings->where('user_id', $this->user->id)
                ->update([
                    'bot_settings' => $property->getId('prediction_types', $request->bot_settings),
                ]);
        }

        return [
            'status' => 'success',
        ];
    }

    public function getUserDetail(Request $request, User $user)
    {
        //
    }

    public function getCurrentUser(User $user)
    {
        return new UserResource($this->user);
    }

    public function deleteUser()
    {
        $this->user->currentAccessToken()->delete();
        $this->user->delete();

        return [
            'status' => 'success',
        ];
    }
}
