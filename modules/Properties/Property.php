<?php

declare(strict_types=1);

namespace Modules\Properties;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'code',
        'value',
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
