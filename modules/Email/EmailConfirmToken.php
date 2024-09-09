<?php

namespace Modules\Email;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfirmToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
    ];
}
