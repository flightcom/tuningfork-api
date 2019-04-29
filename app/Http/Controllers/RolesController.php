<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Exception;
use App\Utils\ExceptionLogger;
use UsersManager;
use Models\Role;

class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:role');
    }

    /**
     * Display the list of specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Role::query()->paginate();

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('role');
            }

            return response()->json($data, 200);
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
            $data =  Role::find($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('role');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
