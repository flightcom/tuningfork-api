<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExceptionLogger;
use Models\Brand;
use Exception;
use UsersManager;

class BrandsController extends Controller
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
            $perPage = $data['perPage'] ?? null;
            $filter = isset($data['filter']) ? json_decode($data['filter']) : null;
            $sort = isset($data['sort']) ? json_decode($data['sort']) : null;

            $brands = Brand::query();

            if ($filter) {
                foreach ($filter as $key => $value) {
                    $brands->where($key, 'LIKE', "%$value%");
                }
            }

            if ($sort) {
                list($field, $direction) = $sort;
                $brands->orderBy($field, $direction);
            }

            if (!$brands) {
                return ExceptionLogger::apiReturnModelNotFound('brand');
            }

            return response()->json($brands->paginate($perPage), 200);
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
            $data =  Brand::find($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('brand');
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
            $brand = Brand::create(['name' => $data['name']]);

            if (!$brand) {
                return ExceptionLogger::apiReturnModelNotFound('brand');
            }

            return response()->json($brand, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
