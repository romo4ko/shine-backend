<?php

declare(strict_types=1);

namespace Modules\Predictions\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Properties\Models\Property;

class Prediction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'text',
        'gender',
        'sign',
        'type',
        'extended',
    ];

    public function sign()
    {
        return $this->hasOne(Property::class);
    }
}
