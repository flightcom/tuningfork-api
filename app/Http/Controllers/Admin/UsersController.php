<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdminViewsManager;
use UsersManager;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:user')
            ->only(['index', 'store']);

        $this->middleware('own:user')
            ->except(['index', 'store', 'create']);

        $this->middleware('permission:user_store')
            ->only(['create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $status = $request->input('status');

        // return view('admin.pages.users.index')
        //     ->with(AdminViewsManager::getUsers($perPage, $search, $status));
        try {
            $data = UsersManager::getUsers($perPage, $search, $status);
            $users = $data->load('location');

            return response()->json($data, 200);
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
    public function store(StoreUser $request)
    {
        try {
            $data = UsersManager::store($request->all());

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
     * Display the specified resource.
     *
     * @param int $user The user id
     *
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
        ApiValidator::make($request->all(), [
            'email' => 'sometimes|email|max:255|unique:users,email,'.$id,
            'first_name' => 'sometimes|max:255',
            'last_name' => 'sometimes|max:255',
            'password' => 'sometimes|confirmed',
            'status' => 'sometimes|string|max:30',
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
     *
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
