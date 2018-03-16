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
            'email' => config('constants.root_user'),
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

        // Create admin user account
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => config('constants.admin_user'),
            'phone' => '0611223355',
            'birth_date' => '1991-05-09',
            'password' => 'q1w2e3r4',
            'status' => config('constants.user_status.ACTIVE'),
        ]);

        // Create moderator user account
        $user = User::create([
            'first_name' => 'Moderator',
            'last_name' => 'User',
            'email' => config('constants.moderator_user'),
            'phone' => '0611223345',
            'birth_date' => '1988-05-09',
            'password' => 'q1w2e3r4',
            'status' => config('constants.user_status.ACTIVE'),
        ]);

        // Create simple user account
        $user = User::create([
            'first_name' => 'Default',
            'last_name' => 'User',
            'email' => config('constants.default_user'),
            'phone' => '0611223344',
            'birth_date' => '1985-05-09',
            'password' => 'q1w2e3r4',
            'status' => config('constants.user_status.ACTIVE'),
        ]);

        $location = new Location([
            'address' => '39 rue Mazureau',
            'postalCode' => '44400',
            'city' => 'Rezé',
            'country' => 'FRANCE',
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
