<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'path',
        'sorting',
    ];
}
