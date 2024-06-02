<?php

declare(strict_types=1);

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Properties\Models\Property;

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

    public static $confirmation = 1;
    public static $moderation = 2;
    public static $rejected = 3;
    public static $blocked = 4;
    public static $published = 5;


    public function getStatuses(): array
    {
        return array_reduce(config('properties.user_statuses'), function ($status, $item) {
            $key = strval($item['code']);
            $value = $item['value'];
            $status[$key] = $value;

            return $status;
        }, []);
    }

    protected static function booted(): void
    {
        static::created(function (User $user) {
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

    protected function getStatusAttribute()
    {
        return fake()->randomElements(['Подтверждение почты', 'На модерации', 'Опубликован']);
    }
}
