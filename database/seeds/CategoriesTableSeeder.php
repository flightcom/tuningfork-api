<?php

use Illuminate\Database\Seeder;
use Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = ['Clavier', 'Batterie', 'Guitare', 'Piano'];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => str_slug($cat, '-'),
            ]);
        }
    }
}
