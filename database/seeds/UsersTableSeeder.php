<?php

use Illuminate\Database\Seeder;
use Models\Location;
use Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create super user account
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'email' => 'admin@tuningfork.fr',
            'phone' => '0612345678',
            'birth_date' => '1985-05-09',
            'password' => 'q1w2e3r4',
            'status' => config('constants.user_status.ACTIVE'),
        ]);

        $location = new Location([
            'address' => '4551 rue Pontiac',
            'address_more' => 'App 2',
            'postalCode' => 'H2J2T2',
            'city' => 'Montréal',
            'country' => 'CANADA',
        ]);

        $user->location()->save($location);

        // Create dummy data
        $faker = Faker\Factory::create('fr_FR');

        foreach (range(1, 10) as $index) {
            $location = new Location([
                'address' => $faker->streetAddress,
                'address_more' => $faker->buildingNumber,
                'postalCode' => $faker->postcode,
                'city' => $faker->city,
                'country' => $faker->country,
            ]);

            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'birth_date' => $faker->date($format = 'Y-m-d'),
                'password' => 'qaqaqa',
                'status' => config('constants.user_status.ACTIVE'),
            ]);

            $user->location()->save($location);
        }
    }
}
