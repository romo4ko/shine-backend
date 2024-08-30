<?php

declare(strict_types=1);

namespace Modules\Chats\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Chats\Models\Chat;
use Modules\Chats\Models\Message;
use Modules\Likes\Like;
use Modules\Users\Models\User;

class MessageController extends Controller
{
    private User $user;

    public function __construct()
    {
        /** @var User $this */
        $this->user = Auth::guard('sanctum')->user();
    }

    // TODO: Refactoring
    public function send(Request $request)
    {
        $request->validate([
            'chat_id' => 'required',
        ]);

        $chat = Chat::findOrFail($request->chat_id);

        if ($request->has('text')) {
            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $this->user->id,
                'text' => $request->text,
            ]);
        } elseif ($request->has('image')) {
            $image = $request->image;
            $fileOriginalName = $image->getClientOriginalExtension();
            $fileNewName = $request->sorting.'_'.time().'.'.$fileOriginalName;
            $path = '/images/chats/'.$chat->id.'/'.$fileNewName;
            $image->storeAs('/images/chats/'.$chat->id, $fileNewName, 'public');
            $url = env('APP_URL');

            $data = [
                'path' => $url.'/storage'. $path,
                'meta' => [
                    'type' => 'image',
                ],
            ];

            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $this->user->id,
                'content' => $data,
            ]);
        }

        if ($chat->status == Chat::REQUESTED) {
            $chat->update(['status' => Chat::CONFIRMED]);
        }

        return [
            'status' => 'success',
            'data' => $data ?? null,
        ];
    }

    // Метод для отправки запроса собеседнику на переписку
    // TODO: Отрефакторить метод
    public function request(Request $request)
    {
        $request->validate([
               'whom' => 'required',
               'text' => 'required',
        ]);

        $recipocity = Like::where([
              'who_id' => $request->whom,
              'whom_id' => $this->user->id,
        ])->first();

        $like = Like::create([
             'who_id' => $this->user->id,
             'whom_id' => $request->whom,
        ]);

        // Если собеседник уже поставил лайк пользователю обновляем статусы лайков и создаем чат если он не создан
        if ($recipocity != null) {

            $recipocity->update(['status' => Like::MATCHED]);
            $like->update(['status' => Like::MATCHED]);

            $chat = Chat::where('initiator_id', $this->user->id)
                ->where('companion_id', $request->whom)
                ->first();

            if ($chat == null) {

                $chat = Chat::create([
                     'initiator_id' => $this->user->id,
                     'companion_id' => $request->whom,
                ]);
            }
        }
        // Создаём чат со статусом ожидания ответа от собеседника
        else {
            $chat = Chat::where('initiator_id', $this->user->id)
                ->where('companion_id', $request->whom)
                ->first();

            if ($chat == null) {

                $chat = Chat::create([
                     'initiator_id' => $this->user->id,
                     'companion_id' => $request->whom,
                     'status' => Chat::REQUESTED,
                ]);
            }
        }
        // В любом случае отправляем собеседнику сообщение
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $this->user->id,
            'text' => $request->text,
        ]);

        return response(['status' => 'success']);
    }
}
