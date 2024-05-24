<?php

namespace Modules\Likes;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'who',
        'whom',
    ];
}
