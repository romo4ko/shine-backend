<?php

declare(strict_types=1);

namespace Modules\Chats\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class Chat extends Model
{
    protected $fillable = [
        'initiator_id',
        'companion_id',
        'status',
    ];

    protected $additional = [
        'status_code',
    ];

    const DEFAULT = 0;

    const REQUESTED = 1;

    const REJECTED = 2;

    const CONFIRMED = 3;

    const BLOCKED_BY_INITIATOR = 4;

    const BLOCKED_BY_COMPANION = 5;

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function companion()
    {
        return $this->belongsTo(User::class, 'companion_id');
    }

    public function getStatusCodeAttribute(): string
    {
        $statuses = [
            self::DEFAULT => 'default',
            self::REQUESTED => 'requested',
            self::REJECTED => 'rejected',
            self::CONFIRMED => 'confirmed',
            self::BLOCKED_BY_INITIATOR => 'blocked_by_initiator',
            self::BLOCKED_BY_COMPANION => 'blocked_by_companion',
        ];

        return $statuses[$this->status];
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
