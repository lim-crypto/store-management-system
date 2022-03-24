<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Pet;
use App\Model\Reservation;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return   User::all()->random();
        },
        'pet_id' => function () {
            return Pet::all()->random();
        },
        'status' => $faker->randomElement(['pending', 'approved','rejected', 'cancelled', 'completed' ]), //  'expired'
        'date' =>  $faker->dateTimeBetween('now',  '+ 7 days'),
    ];
});
