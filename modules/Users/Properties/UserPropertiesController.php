<?php

declare(strict_types=1);

namespace Modules\Users\Properties;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Properties\Models\UserProperties;

class UserPropertiesController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    // For the first time during user registration
    public function storeUserProperties(Request $request, Property $property, City $city): array
    {
        $request->validate(
            [
                'gender' => ['required'],
                'name' => ['required'],
                //                'city'      =>  ['required'],
                //                'fs'        =>  ['required'],
                //                'children'  =>  ['required'],
                //                'smoking'   =>  ['required'],
                //                'alcohol'   =>  ['required'],
                //                'text'      =>  ['required'],
                //                'tags'      =>  ['required'],
            ]
        );

        UserProperties::where('user_id', $this->user->id)
            ->update([
                'name' => $request['name'],
                'gender' => $property->getId('gender', $request['gender']),
                'birthdate' => Carbon::parse($request['birthdate']),
                'city' => $city->getIdByName($request['city']),
                'fs' => $property->getId('fs', $request['fs']),
                'children' => $property->getId('children', $request['children']),
                'smoking' => $property->getId('smoking', $request['smoking']),
                'alcohol' => $property->getId('alcohol', $request['alcohol']),
                'text' => $request['text'],
            ]);
        // Tags

        return [
            'status' => 'success',
        ];
    }

    public function updateUserProperties(Request $request, Property $property, City $city): array
    {
        $relatedProperties = [
            'gender',
            'fs',
            'purpose',
            'children',
            'smoking',
            'alcohol',
            'name',
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
        if ($request->has('text')) {
            UserProperties::where('user_id', $this->user->id)
                ->update(
                    [
                        'text' => $request['text'],
                    ]
                );
        }

        return [
            'status' => 'success',
        ];
    }
}
