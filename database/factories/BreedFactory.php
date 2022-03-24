<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Breed;
use App\Model\Type;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Breed::class, function (Faker $faker) {
    return [
        'type_id' => function () {
            return Type::all()->random();
        },
        'name' => $faker->word,
    ];
});
