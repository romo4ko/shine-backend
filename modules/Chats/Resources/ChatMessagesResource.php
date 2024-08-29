<?php

declare(strict_types=1);

namespace Modules\Chats\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatMessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentUserId = Auth::user()->id;

        if ($currentUserId == $this->initiator->id) {
            $companion = $this->companion;
        } else {
            $companion = $this->initiator;
        }

        return [
            'chat_id' => $this->id,
            'user_id' => $companion->id,
            'self_id' => $currentUserId,
            'user_name' => $companion->properties->name,
            'image' => $companion->getMainImage(),
            'is_online' => false,
            'is_viewed_by_user' => false,
            'messages' => MessageResource::collection($this->messages),
            'status' => $this->statusCode
        ];
    }
}
