<?php

namespace Modules\Users\Images\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = env('APP_URL');

        return [
            'id' => $this->id,
            'path' => $url.'/storage'.$this->path,
            'sorting' => $this->sorting,
        ];
    }
}
