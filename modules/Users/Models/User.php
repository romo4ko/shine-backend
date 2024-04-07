<?php

declare(strict_types=1);

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Properties\Models\Property;
use Modules\Users\Properties\Models\UserProperties;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (User $user) {
            UserSettings::create([
                'user_id' => $user->id,
                'active' => true,
                'status' => Property::getId('user_statuses.confirmation'),
                'bot_settings' => Property::getId('prediction_types.mixed')
            ]);
        });
    }

    public function properties()
    {
        return $this->hasOne(UserProperties::class);
    }
}
