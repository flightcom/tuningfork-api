<?php

namespace App\Http\Controllers;

use App\Utils\ApiValidator;
use Illuminate\Http\Request;
use Exception;
use App\Utils\ExceptionLogger;

use DevicesManager;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = DevicesManager::query();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Register a new Device.
     *
     * @param integer $userId required
     * @param string $token required
     * @param string $type required : in ['ios','android']
     * @param string $uuid required
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        ApiValidator::make($request->all(), [
            'uuid' => 'required|string',
            'type' => 'required|string|in:ios,android',
            'token' => 'required',
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = DevicesManager::store($request->all());

            return response()->json($data, 200);
        } catch (\Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $device The device id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = DevicesManager::show($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('device');
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $uuid required
     * @param string $type required
     * @param string $token required
     * @param int $device The device id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ApiValidator::make($request->all(), [
            'uuid' => 'required|string',
            'type' => 'required|string|in:ios,android',
            'token' => 'required',
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = DevicesManager::update($request->all(), $id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('device');
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $device The device id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = DevicesManager::destroy($id);

            if (!$data) {
                return ExceptionLogger::apiReturnModelNotFound('device');
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }
}
