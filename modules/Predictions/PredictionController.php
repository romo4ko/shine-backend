<?php

namespace Modules\Predictions;

use Illuminate\Support\Facades\Auth;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;

class PredictionController
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }
    public function getPrediction(Property $property): array
    {
        $type = $property->find($this->user->settings->bot_settings);
        if ($type->code == 'mixed') {
            $prediction = Prediction::query()
                ->inRandomOrder()
                ->first();
        }
        else {
            $prediction = Prediction::where('type_id', $type->id)
                ->inRandomOrder()
                ->first();
        }

        return ['text' => $prediction->text];
    }
}
