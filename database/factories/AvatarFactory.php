<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Avatar;
use Faker\Generator as Faker;

$factory->define(Avatar::class, function (Faker $faker) {
    return [
       'path' => $faker->image('public/avatars', $width = 640, $height = 480, 'cats', false),
    ];
});
