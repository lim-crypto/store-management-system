<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Breed;
use App\Model\Pet;
use App\Model\Type;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Pet::class, function (Faker $faker) {
    return [
        'type_id' => function () {
            return Type::all()->random();
        },
        'breed_id' => function () {
            return Breed::all()->random();
        },
        'name' => $faker->lastName,
        'gender'=>$faker->randomElement(['male','female']),
        'images' => json_encode([$faker->randomElement(["image1", "image2", "image3"])]),
        'birthday' => $faker->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),
        'weight' => $faker->numberBetween(0, 20),
        'height' => $faker->numberBetween(0, 20),
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(0, 20),
        // 'status' => $faker->randomElement(['available', 'not available', 'reserved', 'adopted']),
        'status' =>'available',
        'user_id' =>  null,
    ];
});
