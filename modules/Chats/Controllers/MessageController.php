<?php

declare(strict_types=1);

namespace Modules\Chats\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Chats\Models\Message;
use Modules\Users\Models\User;

class MessageController extends Controller
{
    private User $user;

    public function __construct()
    {
        /** @var User $this */
        $this->user = Auth::guard('sanctum')->user();
    }

    public function send(Request $request)
    {
        $request->validate([
            'chat_id' => 'required',
        ]);

        if ($request->has('text')) {
            Message::create([
                'chat_id' => $request->chat_id,
                'sender_id' => $this->user->id,
                'text' => $request->text,
            ]);
        } elseif ($request->has('content')) {
            //
        }

        return ['status' => 'success'];
    }
}
