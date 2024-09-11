<?php

namespace App\Observers;

use App\Mail\UserStatusChanged;
use Illuminate\Support\Facades\Mail;
use Modules\Properties\Property;
use Modules\Users\Models\User;
use Modules\Users\Models\UserProperties;
use Modules\Users\Models\UserSettings;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $property = new Property();
        UserSettings::query()->create([
            'user_id' => $user->id,
            'active' => true,
            'bot_settings' => $property->getId('prediction_types', 'mixed'),
            'pagination' => config('settings.users.pagination'),
            'filter' => config('settings.users.filter'),
        ]);
        UserProperties::query()->create([
            'user_id' => $user->id,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('status')) {
            if ($user->status == User::PUBLISHED || $user->status == User::REJECTED || $user->status == User::BLOCKED) {
                Mail::to($user->email)
                    ->locale('ru')
                    ->send(new UserStatusChanged($user));
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
