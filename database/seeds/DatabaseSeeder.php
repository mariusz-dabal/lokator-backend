<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UserSeeder::class, 10);
        $this->call(ColorSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
