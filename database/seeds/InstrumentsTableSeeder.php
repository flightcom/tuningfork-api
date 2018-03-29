<?php

use Illuminate\Database\Seeder;
use Models\Brand;
use Models\Category;
use Models\Instrument;
use Models\Store;

class InstrumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create dummy data
        $faker = Faker\Factory::create('fr_FR');

        $brands = Brand::all()->pluck('id')->toArray();
        $categories = Category::all()->pluck('id')->toArray();
        $stores = Store::all()->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            Instrument::create([
                'model' => $faker->text(20),
                'serial_number' => $faker->regexify('[A-Z0-9]+[A-Z0-9-]+'),
                'condition' => $faker->numberBetween($min = 1, $max = 5),
                'to_be_checked' => $faker->boolean(25),
                'barcode' => $faker->ean13,
                'brand_id' => $faker->randomElement($brands),
                'category_id' => $faker->randomElement($categories),
                'store_id' => $faker->randomElement($stores),
            ]);
        }
    }
}
