<?php

declare(strict_types=1);

namespace Modules\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Properties\Property;

class UserResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        if (! is_null($this->properties)) {
            $properties = (new UserPropertiesResource($this->properties))->resolve();
        } else {
            $properties = [];
        }

        return [
            'id' => $this->id,
            'image' => $this->getMainImage(),
            'is_premium' => false,
            'active' => $this->settings->active,
            'bot_settings' => $this->getSettings($this->settings->bot_settings),
            'profile_filled' => $this->getProfileFilledPercentage($properties),
            'invites' => 0,
            ...$properties,
            'images' => UserImageResource::collection($this->images),
        ];
    }

    public function getMainImage()
    {
        if (count($this->images)) {
            return env('APP_URL').'/storage'.$this->images[0]->path;
        }
    }

    public function getSettings(?int $id): ?string
    {
        $property = Property::where('id', $id)->first();

        if ($property) {
            return $property->code;
        }

        return null;
    }

    public function getProfileFilledPercentage($properties): int
    {
        $filled = 0;
        $all = 10 + count($properties);

        if ($this->properties->name) {
            $filled += 2;
        }
        if ($this->properties->text) {
            $filled += 2;
            if (strlen($this->properties->text) > 20) {
                $filled++;
            }
        }
        $filled += count(array_filter($properties, function ($property) {
            return $property != null;
        }));
        $filled += count($this->images) / 2;

        $percentage = intval(round($filled / $all * 100));

        return min($percentage, 100);
    }

    public function getImages()
    {

    }
}
