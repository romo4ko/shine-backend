<?php

namespace Modules\Likes;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class Like extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'who_id',
        'whom_id',
        'status',
    ];

    public const MATCHED = 1;

    public const CONFIRMED = 2;

    public const REVOKED = 3;

    public function who()
    {
        return $this->belongsTo(User::class, 'who_id');
    }

    public function whom()
    {
        return $this->belongsTo(User::class, 'whom_id');
    }
}
