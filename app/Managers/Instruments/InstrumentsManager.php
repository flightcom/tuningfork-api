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
        logger($data);

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

        // Cateogry
        // Create new one if slug not exist
        if (array_key_exists('category', $data)) {
            $category = Category::where('slug', str_slug($data['category']))->first();
            if (!$category) {
                try {
                    $category = Category::create([
                        'name' => $data['category'],
                        'slug' => str_slug($data['category']),
                    ]);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
            $instrument->category()->associate($category);
        }


        if (array_key_exists('category_id', $data)) {
            $category = Category::find($data['category_id']);
            if ($category) {
                $instrument->category()->associate($category);
            }
        }

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

        $trim = array_filter($data, function ($value) { return !empty(trim($value)); });

        $instrument->fill($trim);

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
    public function getInstruments($perPage = 15, $search = null, $to_be_checked = null)
    {
        $instruments = Instruments::query();

        if ($search) {
            $instruments->where('model', 'LIKE', "%$search%")
                ->orWhere('serial_number', 'LIKE', "%$search%");
        }

        if ($to_be_checked) {
            $instruments->where('to_be_checked', $to_be_checked);
        }

        return $instruments->paginate($perPage);
    }
}
