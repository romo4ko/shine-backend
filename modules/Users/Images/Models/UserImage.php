<?php

namespace Modules\Users\Images\Models;

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
