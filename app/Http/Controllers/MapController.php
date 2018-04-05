<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExceptionLogger;
use Models\Location;
use Models\Station;
use Models\Store;
use Exception;
use UsersManager;

class MapController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware('RESTpermission:brand');
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
            // Stations
            $stations = Station::all();
            $stations = $stations->map(function ($item) {
                $station = $item->toArray();
                $station['type'] = 'station';
                return $station;
            });

            // Stores
            $stores = Store::all();
            $stores = $stores->map(function ($item) {
                $store = $item->toArray();
                $store['type'] = 'store';
                return $store;
            });

            $data = array_merge(
                $stations->all(),
                $stores->all()
            );

            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
