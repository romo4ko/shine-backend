<?php

namespace Modules\Users\Properties;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\User;
use Modules\Users\Properties\Models\UserProperties;

class UserPropertiesController
{
    public function storeUserProperties(Request $request): array
    {
        $user = Auth::user();
        if ($user) {
            $properties = UserProperties::where('user_id', $user->id)
                ->update(
                    $request->only(
                        [
                            'text',
                            'birthdate',
                            'sex',
                            'city',
                            'purpose',
                            'fs',
                            'children',
                            'smoking',
                            'alcohol',
                            'education',
                            'sign',
                            'height',
                            'tags',
                        ]
                    )
                );
            return ['result' => $properties];
        }
        return ['result' => 0];
    }
}
