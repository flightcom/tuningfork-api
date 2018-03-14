<?php

use Illuminate\Database\Seeder;
use Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $brands = ['Gibson', 'Ibanez', 'Yamaha'];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
            ]);
        }
    }
}
