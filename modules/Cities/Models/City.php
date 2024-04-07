<?php

declare(strict_types=1);

namespace Modules\Cities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'lonlat',
        'data',
    ];

}
