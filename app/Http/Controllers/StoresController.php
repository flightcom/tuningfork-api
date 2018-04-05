<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExceptionLogger;
use Models\Location;
use Models\Store;
use Exception;
use UsersManager;

class StoresController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:store');
    }

    /**
     * Display the list of specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        try {
            $perPage = $data['perPage'] ?? null;
            $filter = isset($data['filter']) ? json_decode($data['filter']) : null;
            $sort = isset($data['sort']) ? json_decode($data['sort']) : null;

            $stores = Store::query();

            if ($filter) {
                foreach ($filter as $key => $value) {
                    $stores->where($key, 'LIKE', "%$value%");
                }
            }

            if ($sort) {
                list($field, $direction) = $sort;
                $stores->orderBy($field, $direction);
            }

            if (!$stores) {
                return ExceptionLogger::apiReturnModelNotFound('store');
            }

            return response()->json($stores->paginate($perPage), 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the list of specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function map(Request $request)
    {
        $data = $request->all();

        try {
            $stores = Store::all();

            if (!$stores) {
                return ExceptionLogger::apiReturnModelNotFound('store');
            }

            return response()->json(['data' => $stores], 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $user The user id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data =  Store::find($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('store');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Create new brand
     *
     * @param string $name      required
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $store = Store::create([
                'name' => $data['name']
            ]);

            if (!$store) {
                return ExceptionLogger::apiReturnModelNotFound('store');
            }

            // If location, save it
            if (array_key_exists('location', $data)) {
                $location = Location::create($data['location']);
                $store->location()->save($location);
            }

            $store->save();

            return response()->json($store, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $email                 optional
     * @param string $first_name            optional
     * @param string $last_name             optional
     * @param string $password              optional
     * @param string $password_confirmation optional if password not set
     * @param string $status                optional
     * @param int    $user                  The user id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            $store = Store::find($id);

            if (!$store) {
                return $store;
            }

            $store->fill($data);

            // If location, save it
            if (array_key_exists('location', $data)) {
                $store->location->fill($data['location']);
                $store->location->save();
            }

            $store = $store->save();

            if (!$store) {
                return ExceptionLogger::apiReturnModelNotFound('store');
            }

            return response()->json($store, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id Id of the store
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Store::destroy($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('store');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
