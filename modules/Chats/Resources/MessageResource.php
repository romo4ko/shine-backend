<?php

declare(strict_types=1);

namespace Modules\Chats\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class MessageResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'text' => $this->text,
            'time' => $this->getTime(),
            'content' => $this->content,
        ];
    }

    public function getTime(): string
    {
        $updated = Carbon::parse($this->created_at);
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
            return $updated->format('m/y');
        }
    }
}
