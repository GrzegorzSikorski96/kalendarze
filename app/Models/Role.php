<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    const SUPERADMIN = 1;
    const ADMIN = 2;
    const USER = 3;
    const BANNED = 4;

    //rola super admina nigdy nie bedzie przyznawana inaczej niż poprzez ręczne dodanie jej do bazy, bądź przez seeder
    public static $roles = [self::ADMIN, self::USER, self::BANNED];

    public $timestamps = false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'users');
    }
}
