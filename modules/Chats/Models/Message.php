<?php

declare(strict_types=1);

namespace Modules\Chats\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_id',
        'text',
        'content',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }
}
