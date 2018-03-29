<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExceptionLogger;
use Models\Category;
use Exception;
use CategoriesManager;

class CategoriesController extends Controller
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

        // error_log(print_r($data, true));

        try {
            $perPage = $data['perPage'] ?? null;
            $filter = isset($data['filter']) ? json_decode($data['filter']) : null;
            $sort = isset($data['sort']) ? json_decode($data['sort']) : null;

            $categories = CategoriesManager::search($perPage, $filter, $sort);

            if (!$categories) {
                return ExceptionLogger::apiReturnModelNotFound('category');
            }

            // return response()->json(['data' => $categories], 200);
            return response()->json($categories, 200);
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
    public function sub(Request $request, $id)
    {
        try {
            $categories = Category::where('category_id', $id)->paginate();

            if (!$categories) {
                return ExceptionLogger::apiReturnModelNotFound('category');
            }

            return response()->json($categories, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
