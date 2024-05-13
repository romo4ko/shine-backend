<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'active',
        'status',
        'bot_settings',
        'page',
        'filter',
        'pagination',
        'extended',
    ];

    protected $casts = [
        'filter' => 'array',
        'pagination' => 'array',
        'extended' => 'array',
    ];

}
