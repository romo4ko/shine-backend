<?php

declare(strict_types=1);

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Properties\Models\Property;
use Modules\Users\Images\Models\UserImage;
use Modules\Users\Properties\Models\UserProperties;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (User $user) {
            $property = new Property();
            UserSettings::query()->create([
                'user_id' => $user->id,
                'active' => true,
                'status' => $property->getId('user_statuses', 'confirmation'),
                'bot_settings' => $property->getId('prediction_types', 'mixed'),
                'pagination' => config('settings.users.pagination'),
                'filter' => config('settings.users.filter'),
            ]);
            UserProperties::query()->create([
                'user_id' => $user->id,
            ]);
        });
    }

    public function properties()
    {
        return $this->hasOne(UserProperties::class);
    }

    public function settings()
    {
        return $this->hasOne(UserSettings::class);
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
    }
}
