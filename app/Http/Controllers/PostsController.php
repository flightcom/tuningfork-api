<?php

namespace App\Http\Controllers;

use App\Utils\ApiValidator;
use Illuminate\Http\Request;
use Exception;
use App\Utils\ExceptionLogger;

use App\Http\Requests;

use PostsManager;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:post')
            ->only(['index', 'store']);

        $this->middleware('own:post')
            ->except(['index', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = PostsManager::query();

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $title required
     * @param text $content required
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ApiValidator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = PostsManager::store($request->all());

            return response()->json($data, 201);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $post The post id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = PostsManager::show($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('post');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $title required
     * @param text $content required
     * @param int $post The post id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ApiValidator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = PostsManager::update($request->all(), $id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('post');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $post The post id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = PostsManager::destroy($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('post');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }
}
