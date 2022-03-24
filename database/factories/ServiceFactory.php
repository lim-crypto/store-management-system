<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'service' => $faker->randomElement(['Grooming', 'Pet boarding', 'Breeding']),
        'offer' => '[{"offer":"Quia libero ad moles","price":"943"},{"offer":"Ut consequatur Opti","price":"22"}]',
    ];
});
