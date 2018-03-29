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
        $categories = [
            'Clavier',
            'Batterie' => ['Électrique'],
            'Guitare' => [
                'Acoustique' => ['Classique', 'Folk'],
                'Électrique'
            ],
            'Piano'
        ];

        function create_category($name, $parent_id)
        {
            $category = new Category([
                'name' => $name,
                'category_id' => $parent_id ?? null,
            ]);
            $category->save();
            return $category->id;
        }

        function rec($tab, $parent = null)
        {
            foreach ($tab as $k => $v) {
                if ($k === (int) $k) { // no sub array
                    create_category($v, $parent);
                } else { // sub array
                    $id = create_category($k, $parent);
                    rec($v, $id);
                }
            }
        }

        rec($categories);
    }
}
