<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExceptionLogger;
use Models\Location;
use Models\Station;
use Exception;
use UsersManager;

class StationsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:station');
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

            $stations = Station::query();

            if ($filter) {
                foreach ($filter as $key => $value) {
                    $brands->where($key, 'LIKE', "%$value%");
                }
            }

            if ($sort) {
                list($field, $direction) = $sort;
                $stations->orderBy($field, $direction);
            }

            if (!$stations) {
                return ExceptionLogger::apiReturnModelNotFound('station');
            }

            return response()->json($stations->paginate($perPage), 200);
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
            $data =  Station::find($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('station');
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
            $station = Station::create([
                'name' => $data['name']
            ]);

            if (!$station) {
                return ExceptionLogger::apiReturnModelNotFound('station');
            }

            // If location, save it
            if (array_key_exists('location', $data)) {
                $location = Location::create($data['location']);
                $station->location()->save($location);
            }

            $station->save();

            return response()->json($station, 200);
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
            $station = Station::find($id);

            if (!$station) {
                return $station;
            }

            $station->fill($data);

            // If location, save it
            if (array_key_exists('location', $data)) {
                $station->location->fill($data['location']);
                $station->location->save();
            }

            $station = $station->save();

            if (!$station) {
                return ExceptionLogger::apiReturnModelNotFound('station');
            }

            return response()->json($station, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
