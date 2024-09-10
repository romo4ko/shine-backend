<?php

declare(strict_types=1);

namespace Modules\Premium\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'plan',
        'name',
        'price',
        'code',
    ];
}
