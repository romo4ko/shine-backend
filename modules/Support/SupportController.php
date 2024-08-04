<?php

namespace Modules\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\User;

class SupportController
{
    private User $user;

    public function create(Request $request, Support $support): array
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        if (Auth::guard('api')->check()) {
            $this->user = Auth::guard('api')->user();

            $support->create([
                'user_id' => $this->user->id,
                'text' => $request->text,
            ]);
        } else {
            $support->create([
                'email' => $request->email,
                'text' => $request->text,
            ]);
        }

        return ['status' => 'success'];
    }
}
