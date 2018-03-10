<?php

namespace App\Http\Controllers;

use App\Utils\ApiValidator;
use Illuminate\Http\Request;
use Exception;
use App\Utils\ExceptionLogger;

use App\Http\Requests;

use UsersManager;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:user')
            ->only(['index']);

        $this->middleware('own:user')
            ->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = UsersManager::query();

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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = UsersManager::show($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('user');
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
     * @param string $email optional
     * @param string $first_name optional
     * @param string $last_name optional
     * @param string $password optional
     * @param string $password_confirmation optional if password not set
     * @param string $status optional
     * @param int $user The user id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ApiValidator::make($request->all(), [
            'email' => 'sometimes|email|max:255|unique:users,email,'.$id,
            'first_name' => 'sometimes|max:255',
            'last_name' => 'sometimes|max:255',
            'password' => 'sometimes|confirmed',
            'status' => 'sometimes|string|max:30'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = UsersManager::update($request->all(), $id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('user');
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
     * @param int $user The user id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = UsersManager::destroy($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('user');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }
}
