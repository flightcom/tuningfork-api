<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\SubscribeRequest;
use App\Utils\ExceptionLogger;
use Models\User;
use Exception;
use UsersManager;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:user')
            ->except(['show', 'update']);
        $this->middleware('own:user')
            ->only(['show', 'update']);
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

            $data = UsersManager::search($perPage, $filter, $sort);

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

    /**
     * Subscribe a user
     *
     * @param SubscribeRequest $request     the request
     * @param int $id       the user id
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(SubscribeRequest $request, $id)
    {
        try {
            $user = User::find($id);
            if ($user->has_subscribed) {
                return response()->json('User has already subscribed', 500);
            }
            $data = UsersManager::subscribe($request->all(), $id);

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
     * Unsubscribe a user
     *
     * @param SubscribeRequest $request     the request
     * @param int $id       the user id
     *
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user->has_subscribed) {
                return response()->json('User has not subscribed', 500);
            }

            $data = UsersManager::unsubscribe($id);

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
