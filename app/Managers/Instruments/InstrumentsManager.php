<?php

namespace Managers\Instruments;

use Exception;
use Models\Brand;
use Models\Category;
use Models\Instrument;

class InstrumentsManager
{
    /*
    |--------------------------------------------------------------------------
    | InstrumentsManager
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
        return Instrument::paginate();
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function store(array $data)
    {
        $instrument = new Instrument([
            'model' => $data['model'],
            'serial_number' => $data['serial_number'] ?? null,
            'barcode' => $data['barcode'] ?? null,
            'condition' => $data['condition'] ?? false,
            'to_be_checked' => $data['to_be_checked'] ?? false,
            'comment' => $data['comment'] ?? null,
        ]);

        if (array_key_exists('brand_id', $data)) {
            $brand = Brand::find($data['brand_id']);
            if ($brand) {
                $instrument->brand()->associate($brand);
            }
        }

        // Brand
        // Create new one if slug not exist
        if (array_key_exists('brand', $data)) {
            $brand = Brand::where('slug', str_slug($data['brand']))->first();
            if (!$brand) {
                try {
                    $brand = Brand::create([
                        'name' => $data['brand'],
                        'slug' => str_slug($data['brand']),
                    ]);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
            $instrument->brand()->associate($brand);
        }

        // Category
        if (array_key_exists('category_ids', $data)) {
            $categories = array_reverse($data['category_ids']);
            $last_category_id = $categories[0];
            // Check if category exists
            if ($cat_exists = Category::find($last_category_id)) {
                $category = $cat_exists;
            } elseif (isset($categories[1]) && $cat_exists = Category::where([
                ['category_id', '=', $categories[1]],
                ['slug', '=', str_slug($categories[0])],
            ])->first()) {
                $category = $cat_exists;
            } else {
                $category = new Category(['name' => $categories[0]]);
                if (isset($categories[1]) && $parent = Category::find($categories[1])) {
                    $category->category()->associate($parent);
                }
                $category->save();
            }
            $instrument->category()->associate($category);
        }

        // Store
        if (array_key_exists('store_id', $data)) {
            $store = Store::find($data['store_id']);
            if ($store) {
                $instrument->store()->associate($store);
            }
        }

        $instrument->save();

        return $instrument;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return Instrument::find($id);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $instrument = Instrument::find($id);

        if (!$instrument) {
            return $instrument;
        }

        $instrument->fill($data);

        // Category
        if (array_key_exists('category_ids', $data)) {
            $categories = array_reverse($data['category_ids']);
            $last_category_id = $categories[0];
            // Check if category exists
            if ($cat_exists = Category::find($last_category_id)) {
                $category = $cat_exists;
            } elseif (isset($categories[1]) && $cat_exists = Category::where([
                ['category_id', '=', $categories[1]],
                ['slug', '=', str_slug($categories[0])],
            ])->first()) {
                $category = $cat_exists;
            } else {
                $category = new Category(['name' => $categories[0]]);
                if (isset($categories[1]) && $parent = Category::find($categories[1])) {
                    $category->category()->associate($parent);
                }
                $category->save();
            }
            $instrument->category()->associate($category);
        }

        return $instrument->save();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return Instrument::destroy($id);
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
        $instruments = Instrument::query();

        if ($filter) {
            foreach ($filter as $key => $value) {
                switch ($key) {
                    case 'brand':
                        $instruments->where('brand_id', $value->id)->get();
                        break;
                    case 'to_be_checked':
                        $instruments->where($key, $value);
                        break;
                    default:
                        $instruments->where($key, 'LIKE', "%$value%");
                }
            }
        }

        if ($sort) {
            list($field, $direction) = $sort;
            $instruments->orderBy($field, $direction);
        }

        return $instruments->paginate($perPage);
    }
}
