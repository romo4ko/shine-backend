<?php

declare(strict_types=1);

namespace Modules\Chats\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\User;

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
            'image' => $this->getMainImage($companion),
            'is_online' => false,
            'is_viewed_by_user' => false,
            'messages' => MessagesResource::collection($this->messages),
        ];
    }

    public function getMainImage(User $companion)
    {
        return env('APP_URL').'/storage'.$companion->images[0]->path;
    }
}
