<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            Role::SUPERADMIN => 'SUPERADMIN',
            Role::ADMIN => 'ADMIN',
            Role::USER => 'USER',
            Role::BANNED => 'BANNED',
        ];

        foreach ($roles as $key => $value) {
            Role::firstOrCreate([
                'id' => $key,
                'name' => $value,
            ]);
        }
    }
}