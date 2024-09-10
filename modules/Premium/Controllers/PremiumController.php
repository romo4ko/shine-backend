<?php

declare(strict_types=1);

namespace Modules\Premium\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Premium\Models\Price;
use Modules\Premium\Resources\PriceResource;
use Modules\Users\Models\User;

class PremiumController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    public function getPrices()
    {
        $expiresAfterInDays = config('settings.premium.expires_after');

        if (Carbon::now()->diffInDays($this->user->created_at) < $expiresAfterInDays) {
            return PriceResource::collection(Price::all())
                ->additional([
                   'meta' => [
                       'secondsLeft' => Carbon::now()->diffInSeconds(
                           $this->user->created_at->addDays($expiresAfterInDays)
                       )
                   ],
               ]);
        }
        return PriceResource::collection(Price::all());
    }
}
