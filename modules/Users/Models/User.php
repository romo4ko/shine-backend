<?php

declare(strict_types=1);

namespace Modules\Users\Models;

use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Premium\Models\PremiumUser;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public $timestamps = true;

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
        'status' => 'integer',
    ];

    protected $appends = [
        'is_premium',
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

    public function getIsPremiumAttribute(): bool
    {
        return $this->isPremium();
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

    public function isPremium(): bool
    {
        return PremiumUser::where('user_id', $this->id)
            ->where('expire_at', '>', Carbon::now())
            ->exists();
    }
}
