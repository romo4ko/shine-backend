<?php

declare(strict_types=1);

namespace Modules\Predictions;

use Illuminate\Database\Eloquent\Model;
use Modules\Properties\Property;

class Prediction extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'text',
        'gender_id',
        'sign_id',
        'type_id',
        'extended',
    ];

    protected $casts = [
        'extended' => 'array',
    ];

    public function gender()
    {
        return $this->belongsTo(Property::class);
    }

    public function type()
    {
        return $this->belongsTo(Property::class);
    }

    public function sign()
    {
        return $this->belongsTo(Property::class);
    }
}
