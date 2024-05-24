<?php

declare(strict_types=1);

namespace Modules\Chats\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Chats\Models\Chat;
use Modules\Users\Models\User;

class ChatCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        $currentUserId = Auth::user()->id;

        return $this->map(function (Chat $chat) use ($currentUserId) {

            if ($currentUserId == $chat->initiator->id) {
                $companion = $chat->companion;
            } else {
                $companion = $chat->initiator;
            }

            return [
                'id' => $chat->id,
                'name' => $companion->properties->name,
                'image' => $this->getMainImage($companion),
                'last_message' => 'test',
                'time' => $this->getTime($chat),
                'is_viewed' => false,
            ];
        });
    }

    public function getTime(Chat $chat): string
    {
        $updated = Carbon::parse($chat->updated_at);
        if ($updated->isToday()) {
            return $updated->format('H:i');
        }

        if ($updated->isYesterday()) {
            return 'вчера';
        }

        return $updated->diffInDays(Carbon::now()).' дней';
    }

    public function getMainImage(User $companion)
    {
        return env('APP_URL').'/storage'.$companion->images[0]->path;
    }
}
