<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarUsers extends Model
{
    public function calendar():BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id')->where('deleted_at', null);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,' user_id')->where('deleted_at', null);
    }
}