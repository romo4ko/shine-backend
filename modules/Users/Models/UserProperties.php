<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProperties extends Model
{
    use HasFactory;

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
