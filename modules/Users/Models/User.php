<?php

declare(strict_types=1);

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Properties\Property;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
        'status',
        'login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'login_at' => 'datetime',
    ];

    public const CONFIRMATION = 0;

    public const MODERATION = 1;

    public const REJECTED = 2;

    public const BLOCKED = 3;

    public const PUBLISHED = 4;

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
