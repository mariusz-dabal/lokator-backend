<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 15)->create()->each(function ($user) {
            $user->roles()->attach(Role::where('id', mt_rand(1, 3))->first());
        });
    }
}
