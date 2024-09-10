<?php

declare(strict_types=1);

namespace Modules\Premium\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PriceResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $user = Auth::guard('api')->user();
        $discount = config('settings.premium.discount');
        $expiresAfterInDays = config('settings.premium.expires_after');

        if (Carbon::now()->diffInDays($user->created_at) > $expiresAfterInDays) {
            return [
                $this->plan => [
                    'name' => $this->name,
                    'price' => $this->price,
                    'code' => $this->code,
                ]
            ];
        }

        return [
            $this->plan => [
                'name' => $this->name,
                'price' => $this->price,
                'code' => $this->code,
                'cost' => ($this->price * $discount / 100),
            ]
        ];

    }
}
