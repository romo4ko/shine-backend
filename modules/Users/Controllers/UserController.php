<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Cities\Models\City;
use Modules\Properties\Property;
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

    public function getUsersList(Property $property): UserCollection
    {
        $user = Auth::user();

        $count = config('settings.pagination.count');
        $page = $user->settings->page;
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $filter = $this->user->settings->filter ?? config('settings.users.filter');
        if ($filter['gender'] == 'all' || is_null($filter['gender'])) {
            $gender = null;
        } else {
            $gender = $property->getId('gender', $filter['gender']);
        }

        $users = User::query()
            ->join('user_settings', 'users.id', '=', 'user_settings.user_id')
            ->join('user_properties', 'users.id', '=', 'user_properties.user_id')
            ->where('users.id', '!=', $user->id)
            ->where('status', User::PUBLISHED)
            ->where('user_settings.active', 1)
            ->whereDate('user_properties.birthdate', '<=', Carbon::now()->subYears($filter['age']['from']))
            ->whereDate('user_properties.birthdate', '>=', Carbon::now()->subYears($filter['age']['to']))
            ->when($gender != null, function ($query) use ($gender) {
                $query->where('user_properties.gender', $gender);
            })
            ->paginate($count);

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
                    'filter' => $filter,
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
        if ($request->has('city')) {
            $city = $city->where('name', $request->city)->first();
            if ($city == null) {
                return [
                    'status' => 'error',
                    'message' => 'Город не найден',
                ];
            } else {
                UserProperties::where('user_id', $this->user->id)
                    ->update(
                        [
                            'city' => $city->id,
                        ]
                    );
            }
        }
        if ($request->hasAny(['text', 'name', 'height'])) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    $request->only(['text', 'name', 'height'])
                );
        }

        // TODO: add tags

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
        $request->validate([
            'user' => 'required|exists:users,id',
        ]);

        return new UserResource($user->find($request->user));
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

    public function setFilter(Request $request)
    {
        $request->validate([
            'gender' => 'required',
            'age' => 'required',
            'destiny' => 'required',
        ]);

        $this->user->settings->filter = $request->only([
            'gender',
            'age',
            'destiny',
        ]);
        $this->user->settings->save();

        return [
            'status' => 'success',
        ];
    }

    public function getFilter(Property $property)
    {
        $available = [];

        $purpose = $property->find($this->user->properties->purpose);
        $gender = $property->find($this->user->properties->gender);

        if (in_array($purpose->code, ['dates', 'flirting', 'relationship'])) {
            if ($gender->code == 'male') {
                $available = ['female'];
            } elseif ($gender->code == 'female') {
                $available = ['male'];
            }
        } else {
            $available = ['male', 'female', 'all'];
        }

        $filter = $this->user->settings->filter ?? config('settings.users.filter');

        return [
            'filter' => $filter,
            'available' => $available,
        ];
    }
}
