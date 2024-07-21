<?php

namespace Modules\Documents;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'text',
    ];
}
