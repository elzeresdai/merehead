<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Book::class, function (Faker $faker) {
    return [
        'title'=> $faker->sentence($nbWords = rand(1,3), $variableNbWords = true),
        'pages'=> rand(100,1000),
        'annotation'=>$faker->sentence(5),
        'img'=>base64_decode($faker->image())
    ];
});
