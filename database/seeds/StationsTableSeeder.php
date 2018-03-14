<?php

use Illuminate\Database\Seeder;
use Models\Station;
use Models\Location;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $location = new Location([
            'address' => '6 Boulevard Léon Bureau',
            'address_more' => '',
            'postalCode' => '44200',
            'city' => 'Nantes',
            'country' => 'FRANCE',
        ]);

        $station = Station::create([
            'name' => 'Trempolino',
        ]);

        $station->location()->save($location);
    }
}
