<?php

namespace Managers\Categories;

use Exception;
use Models\Brand;
use Models\Category;

class CategoriesManager
{
    /*
    |--------------------------------------------------------------------------
    | CategoriesManager
    |--------------------------------------------------------------------------
    |
    | The UsersManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return Category::paginate();
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function store(array $data)
    {
        $category = new Category([
            'name' => $data['name'],
            'category_id' => $data['category_id'] ?? null,
        ]);

        return $category->save();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $category;
        }

        $trim = array_filter($data, function ($value) {
            return !empty(trim($value));
        });

        $category->fill($trim);

        return $category->save();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return Category::destroy($id);
    }

    /**
     * This function returns required information to display on the instruments
     * view.
     *
     * @param int    $perPage
     * @param string $search
     * @param string $to_be_checked
     *
     * @return array
     */
    public function search($perPage = 15, $filter = null, $sort = null)
    {
        $parent = null;

        $categories = Category::query();

        if ($filter) {
            foreach ($filter as $key => $value) {
                if (substr($key, 0, 1) === '_') {
                    continue;
                }
                switch ($key) {
                    case 'category_id':
                        $categories->ofCategory($value)->get();            
                        break;
                    case 'id':
                        if (!empty($value)) {
                            $categories->whereIn('id', $value);
                        }
                        break;
                    case 'q':
                        $categories->where('name', 'LIKE', "$value%");
                        break;
                    // default:
                    //     $categories->where($key, 'LIKE', "%$value%");
                }
            }
        }

        if ($sort) {
            list($field, $direction) = $sort;
            $categories->orderBy($field, $direction);
        }

        return $categories->paginate(100);
        // return $categories->get();
    }
}
