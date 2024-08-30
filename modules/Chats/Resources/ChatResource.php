<?php

declare(strict_types=1);

namespace Modules\Chats\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $currentUserId = Auth::user()->id;

        if ($currentUserId == $this->initiator->id) {
            $companion = $this->companion;
        } else {
            $companion = $this->initiator;
        }

        return [
            'id' => $this->id,
            'name' => $companion->properties->name,
            'image' => $companion->getMainImage(),
            'last_message' => count($this->messages) === 0 ? '' : $this->messages->last()->text,
            'time' => $this->getTime(),
            'is_viewed' => $this->messages->last()?->sender_id == $currentUserId || $this->messages->last()?->is_viewed === true,
            'status' => $this->statusCode,
        ];
    }

    public function getTime(): string
    {
        $updated = count($this->messages) === 0 ?
            Carbon::parse($this->updated_at) :
            Carbon::parse($this->messages->last()->created_at);

        if ($updated->isToday()) {
            return $updated->format('H:i');
        }

        if ($updated->isYesterday()) {
            return 'вчера';
        }

        $diff = $updated->diffInDays(Carbon::now());
        if ($diff < 10) {
            return $updated->diffInDays(Carbon::now()).Lang::choice(' день| дня| дней', $diff, [], 'ru');
        } else {
            return $updated->format('d.m.Y');
        }
    }
}
