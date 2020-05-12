<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->name = 'User';
        $role_user->description = 'Regular user';
        $role_user->save();

        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'App admin';
        $role_admin->save();

        $role_flat_admin = new Role();
        $role_flat_admin->name = 'Flat Administrator';
        $role_flat_admin->description = 'User responsible for the flat';
        $role_flat_admin->save();
    }
}
