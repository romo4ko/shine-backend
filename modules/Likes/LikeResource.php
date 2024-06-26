<?php

declare(strict_types=1);

namespace Modules\Likes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    public static $wrap = null;

    public function with($request)
    {
        return [
            'likes' => $this->resource,
        ];
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->who_id,
            'name' => $this->who->properties->name,
            'image' => $this->who->getMainImage(),
        ];
    }
}
