<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Utils\ExceptionLogger;
use Exception;
use LoansManager;

class LoansController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:loan');
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

            $data = LoansManager::search($perPage, $filter, $sort);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('loan');
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
            $data = LoansManager::show($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('loan');
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
            $data = LoansManager::store($request->all());

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('loan');
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
            $data = LoansManager::update($request->all(), $id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('loan');
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
            $data = LoansManager::destroy($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('loan');
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);

            return response()->json($e->getMessage(), 500);
        }
    }
}
