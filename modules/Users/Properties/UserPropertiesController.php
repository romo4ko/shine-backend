<?php

namespace Modules\Users\Properties;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Properties\Models\UserProperties;

class UserPropertiesController
{
    public function storeUserProperties(Request $request, Property $property, City $city): array
    {
        $request->validate(
            [
                'sex'       =>  ['required'],
                'birthdate' =>  ['required'],
                'city'      =>  ['required'],
                'fs'        =>  ['required'],
                'children'  =>  ['required'],
                'smoking'   =>  ['required'],
                'alcohol'   =>  ['required'],
                'text'      =>  ['required'],
                'tags'      =>  ['required'],
            ]
        );

        $user = Auth::user();
        if ($user) {
            $user->update([
                'name' => $request['name']
            ]);
            UserProperties::where('user_id', $user->id)
                ->update([
                    'sex' => $property->getId('sex.' . $request['sex']),
                    'birthdate' => Carbon::parse($request['birthdate']),
                    'city' => $city->getIdByName($request['city']),
                    'fs' => $property->getId('fs.' . $request['fs']),
                    'children' => $property->getId('children.' . $request['children']),
                    'smoking' => $property->getId('smoking.' . $request['smoking']),
                    'alcohol' => $property->getId('alcohol.' . $request['alcohol']),
                    'text' => $request['text'],
                    'tags' => $request['tags'],
            ]);

            return [
                'status' => 'success'
            ];
        }
        return [
            'status' => 'error',
            'message' => 'Пользователь не найден'
        ];
    }

    public function updateUserProperty(Request $request, Property $property, City $city): array
    {
        return [
            'status' => 'error',
            'message' => 'Пользователь не найден'
        ];
    }
}
