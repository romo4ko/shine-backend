<?php

namespace Modules\Users\Properties\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Properties\Models\Property;

class UserProperties extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'text',
        'birthdate',
        'sex',
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
}
