<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Exception;
use App\Utils\ExceptionLogger;
use UsersManager;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:user')
            ->except('update');
        $this->middleware('own:user')
            ->only(['show', 'update']);
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
    public function store(UserRequest $request)
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
    public function update(UserRequest $request, $id)
    {
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
