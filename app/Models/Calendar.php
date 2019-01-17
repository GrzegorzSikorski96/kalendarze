<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'is_private', 'owner_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'pivot'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'calendar_users', 'calendar_id', 'user_id')->where('deleted_at', null);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'calendar_id')->where('deleted_at', null);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')->where('deleted_at', null);
    }
}