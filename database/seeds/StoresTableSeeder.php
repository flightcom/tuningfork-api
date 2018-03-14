<?php

use Illuminate\Database\Seeder;
use Models\Location;
use Models\Store;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $stores = ['Store 1', 'Store 2', 'Store 3'];

        $faker = Faker\Factory::create('fr_FR');

        foreach ($stores as $store) {
            $location = new Location([
                'address' => $faker->streetAddress,
                'address_more' => $faker->buildingNumber,
                'postalCode' => $faker->postcode,
                'city' => $faker->city,
                'country' => $faker->country,
            ]);

            $store = Store::create([
                'name' => $store,
            ]);

            $store->location()->save($location);
        }
    }
}
