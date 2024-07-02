<?php

declare(strict_types=1);

namespace Modules\Predictions;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'text',
        'gender_id',
        'sign_id',
        'type_id',
        'extended',
    ];
}
