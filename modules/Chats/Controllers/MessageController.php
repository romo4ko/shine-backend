<?php

declare(strict_types=1);

namespace Modules\Chats\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Chats\Models\Chat;
use Modules\Users\Models\User;

class MessageController extends Controller
{
    private User $user;

    public function __construct()
    {
        /** @var User $this */
        $this->user = Auth::guard('sanctum')->user();
    }

    public function list(Request $request)
    {
        $request->validate([
            'chat_id' => 'required',
        ]);
        $chat = Chat::findOrFail($request->chat_id);

        return $chat->messages;
    }
}
