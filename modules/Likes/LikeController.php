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
            Chat::create([
                'initiator' => $this->user->id,
                'companion' => $request->whom,
            ]);

            return response(['status' => 'match']);
        }

        return response(['status' => 'success']);
    }
}
