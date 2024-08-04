<?php

namespace Modules\Support;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class Support extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'text',
        'answer',
        'user_id',
        'email',
        'status',
    ];

    public const NEW = 0;

    public const IN_PROGRESS = 1;

    public const DONE = 2;

    public const STATUSES = [
        Support::NEW => 'Новое',
        Support::IN_PROGRESS => 'Обрабатывается',
        Support::DONE => 'Обработано',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusNameAttribute()
    {
        return Support::STATUSES[$this->status];
    }

    public function getProcessedAtAttribute(): ?Carbon
    {
        if ($this->status !== Support::NEW) {
            return $this->updated_at;
        }

        return null;
    }
}
