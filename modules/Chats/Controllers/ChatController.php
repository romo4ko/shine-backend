<?php

declare(strict_types=1);

namespace Modules\Chats\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Chats\Models\Chat;
use Modules\Chats\Resources\ChatMessagesResource;
use Modules\Chats\Resources\ChatResource;
use Modules\Users\Models\User;

class ChatController extends Controller
{
    private User $user;

    public function __construct()
    {
        /** @var User $this */
        $this->user = Auth::guard('sanctum')->user();
    }

    public function list(Request $request)
    {
        $chats = Chat::where('initiator_id', $this->user->id)
            ->orWhere('companion_id', $this->user->id)
            ->get();

        return ChatResource::collection($chats);
    }

    public function messages(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|integer',
        ]);
        $chat = Chat::findOrFail($request->chat_id);

        return new ChatMessagesResource($chat);
    }
}
