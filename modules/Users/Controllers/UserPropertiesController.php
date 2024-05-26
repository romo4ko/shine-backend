<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Models\UserProperties;

class UserPropertiesController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::guard('sanctum')->user();
    }

    // Store or update any user properties
    public function updateUserProperties(Request $request, Property $property, City $city): array
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
                UserProperties::where('user_id', $this->user->id)
                    ->update([
                        $type => $property->getId($type, $code),
                    ]);
            }
        }
        if ($request->has('birthdate')) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    [
                        'birthdate' => Carbon::parse($request['birthdate']),
                    ]
                );
        }
        if ($request->has('city')) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    [
                        'city' => $city->getIdByName($request['city']),
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
}
