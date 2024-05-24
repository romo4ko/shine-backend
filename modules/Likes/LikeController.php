<?php

declare(strict_types=1);

namespace Modules\Likes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Chats\Models\Chat;
use Modules\Users\Models\User;

class LikeController extends Controller
{
    private User $user;

    public function __construct()
    {
        /** @var User $this */
        $this->user = Auth::guard('sanctum')->user();
    }

    public function like(Request $request, Like $like): array|Response
    {
        $recipocity = Like::where([
            'who' => $request->whom,
            'whom' => $this->user->id,
        ])->first();

        Like::create([
            'who' => $this->user->id,
            'whom' => $request->whom,
        ]);

        if ($recipocity != null) {

            $chat = Chat::where('initiator_id', $this->user->id)
                ->where('companion_id', $request->whom)
                ->first();

            if ($chat == null) {

                Chat::create([
                    'initiator_id' => $this->user->id,
                    'companion_id' => $request->whom,
                ]);

                return response(['status' => 'match']);
            }
        }

        return response(['status' => 'success']);
    }
}
