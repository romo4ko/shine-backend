<?php
declare(strict_types=1);

namespace Modules\Properties\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'code',
        'value',
    ];

}
