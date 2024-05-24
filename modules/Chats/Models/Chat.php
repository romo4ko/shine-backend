<?php

declare(strict_types=1);

namespace Modules\Chats\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class Chat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'initiator_id',
        'companion_id',
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function companion()
    {
        return $this->belongsTo(User::class, 'companion_id');
    }
}
