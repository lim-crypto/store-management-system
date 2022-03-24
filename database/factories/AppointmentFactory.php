<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Appointment;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return   User::all()->random();
        },
        'service' => $faker->word,
        'offer' => $faker->word,
        'date' => $faker->dateTimeBetween('now', '+1 months'),
        'status' => $faker->randomElement(['pending', 'approved','rejected', 'cancelled']),

    ];
});
