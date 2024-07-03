<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Properties\Property;

class UserSettings extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'active',
        'bot_settings',
        'page',
        'filter',
        'pagination',
        'extended',
    ];

    protected $casts = [
        'active' => 'boolean',
        'filter' => 'array',
        'pagination' => 'array',
        'extended' => 'array',
    ];

    public function getId(string $type, string $code): ?int
    {
        $property = Property::where('type', $type)->where('code', $code)->first();
        if ($property) {
            return $property->id;
        }

        return null;
    }
}
