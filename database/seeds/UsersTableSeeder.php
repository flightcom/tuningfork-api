<?php

use Illuminate\Database\Seeder;

use Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create super user account
        User::create([
            'email' => 'dev@osedea.com',
            'first_name' => 'Super',
            'last_name' => 'User',
            'password' => 'asdfasdf',
            'status' => config('constants.user_status.ACTIVE')
        ]);

        // Create dummy data
        $faker = Faker\Factory::create();

        foreach(range(1, 500) as $index) {
            User::create([
                'email' => $faker->email,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'password' => 'asdfasdf',
                'status' => config('constants.user_status.ACTIVE')
            ]);
        }
    }
}
