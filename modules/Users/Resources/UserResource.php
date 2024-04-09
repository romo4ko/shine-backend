<?php

declare(strict_types=1);

namespace Modules\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Users\Images\Resources\UserImageResource;
use Modules\Users\Properties\Resources\UserPropertiesResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!is_null($this->properties)) {
            $properties = new UserPropertiesResource($this->properties);
        } else {
            $properties = null;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'properties' => $properties,
            'images' => UserImageResource::collection($this->images)
        ];
    }
}
