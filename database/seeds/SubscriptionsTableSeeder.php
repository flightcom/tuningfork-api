<?php

use Illuminate\Database\Seeder;
use Models\Subscription;
use Models\User;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();
        $nb_users = User::all()->count();

        // Create dummy data
        $faker = Faker\Factory::create('fr_FR');

        foreach (range(1, min(10, $nb_users)) as $index) {
            $date = $faker->date('Y-m-d H:i:s');
            Subscription::create([
                'starts_at' => $date,
                'ends_at' => getMembershipEndDate($date),
                'user_id' => $users->get($index)->id,
            ]);
        }
    }
}
