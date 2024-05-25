<?php

declare(strict_types=1);

namespace Modules\Chats\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\User;

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
            'image' => $this->getMainImage($companion),
            'last_message' => $this->messages->last()->text,
            'time' => $this->getTime(),
            'is_viewed' => true,
        ];
    }

    public function getTime(): string
    {
        $updated = Carbon::parse($this->updated_at);
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
