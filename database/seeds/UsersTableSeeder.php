<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('asdasd'),
            'remember_token' => str_random(10),
            'description' => str_random(150),
            'role_id' => Role::all()->random(1)->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        factory(User::class, 50)->create();
    }
}
