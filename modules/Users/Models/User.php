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
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const confirmation = 0;

    public const moderation = 1;

    public const rejected = 2;

    public const blocked = 3;

    public const published = 4;

    public function getStatuses(): array
    {
        return array_reduce(config('properties.user_statuses'), function ($status, $item) {
            $key = strval($item['code']);
            $value = $item['value'];
            $status[$key] = $value;

            return $status;
        }, []);
    }

    public function getStatusNameAttribute(): string
    {
        $statuses = config('properties.user_statuses');

        return $statuses[$this->status]['value'];
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

    public function getMainImage(): ?string
    {
        if (count($this->images)) {
            return env('APP_URL').'/storage'.$this->images[0]->path;
        }
        return null;
    }
}
