<?php

namespace Modules\Users\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Users\Models\User;
use Modules\Users\Resources\UserImageResource;

class UserImageController
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function store(Request $request)
    {
        $request->validate([
            'sorting' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $image = $request->image;
        $fileOriginalName = $image->getClientOriginalExtension();
        $fileNewName = $request->sorting.'_'.time().'.'.$fileOriginalName;
        $path = '/images/users/'.$this->user->id.'/'.$fileNewName;
        $image->storeAs('/images/users/'.$this->user->id, $fileNewName, 'public');

        $last = $this->user
            ->images()
            ->where('sorting', $request->sorting)
            ->first();
        if ($last !== null) {
            File::delete($last->path);
        }

        $this->user->images()->updateOrInsert(
            [
                'user_id' => $this->user->id,
                'sorting' => $request->sorting,
            ],
            [
                'path' => $path,
            ]
        );

        $saved = $this->user
            ->images()
            ->where('sorting', $request->sorting)
            ->first();

        return new UserImageResource(
            $saved
        );
    }
}
