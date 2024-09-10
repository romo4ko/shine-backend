<?php

declare(strict_types=1);

namespace Modules\Premium\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumUser extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'expire_at',
    ];
}
