<?php

namespace Modules\Support;

use Illuminate\Support\Facades\Auth;
use Modules\Predictions\Prediction;
use Modules\Properties\Property;
use Modules\Users\Models\User;

class SupportController
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    public function create(Support $support): array
    {
        $support->create([
            'user_id' => $this->user->id,
            'text' => request('text'),
         ]);

        return ['status' => 'success'];
    }
}
