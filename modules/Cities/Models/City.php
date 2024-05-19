<?php

declare(strict_types=1);

namespace Modules\Cities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'lonlat',
        'data',
    ];

    public function getIdByName(string $name)
    {
        $city = City::where('name', $name)->first();
        if ($city) {
            return $city->id;
        }
        return null;
    }
}
