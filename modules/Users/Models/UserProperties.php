<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserProperties extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'text',
        'birthdate',
        'gender',
        'city',
        'purpose',
        'fs',
        'children',
        'smoking',
        'alcohol',
        'education',
        'sign',
        'height',
        'tags',
    ];

    protected $casts = [
        'birthdate' => 'date:d.m.Y',
    ];
}
