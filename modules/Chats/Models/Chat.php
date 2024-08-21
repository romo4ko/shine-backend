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

    const DEFAULT = 0;

    const REJECTED = 1;

    const CONFIRMED = 2;

    const BLOCKED_BY_INITIATOR = 3;

    const BLOCKED_BY_COMPANION = 4;

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function companion()
    {
        return $this->belongsTo(User::class, 'companion_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
