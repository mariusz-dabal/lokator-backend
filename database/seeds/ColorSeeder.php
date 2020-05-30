<?php

use App\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::truncate();

        Color::create(['name'=> 'red']);
        Color::create(['name'=> 'green']);
        Color::create(['name'=> 'Blue']);
        Color::create(['name'=> 'pink']);
        Color::create(['name'=> 'yellow']);
        Color::create(['name'=> 'black']);
    }
}
