<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'calendar_id', 'description',' start_date', 'start_time', 'end_date', 'end_time', 'color'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function created_by() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function calendar() : BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }
}