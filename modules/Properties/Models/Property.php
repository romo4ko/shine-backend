<?php
declare(strict_types=1);

namespace Modules\Properties\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'code',
        'value',
    ];

    public static function getId(string $typecode): int
    {
        $typecode = explode('.', $typecode);
        
        return Property::where('type', $typecode[0])->where('code', $typecode[1])->first()->id;
    }

}
