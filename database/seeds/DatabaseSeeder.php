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
        $this->call(UserSeeder::class);

        // factory(App\Model\User::class, 10)->create();
        // factory(App\Model\Type::class, 2)->create();
        // factory(App\Model\Breed::class, 10)->create();
        // factory(App\Model\Pet::class, 30)->create();
        // factory(App\Model\Reservation::class, 10)->create();
        // factory(App\Model\Appointment::class, 10)->create();
        // factory(App\Model\Service::class, 3)->create();

    }
}
