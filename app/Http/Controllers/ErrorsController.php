<?php

namespace App\Http\Controllers;

use App\Utils\ApiValidator;
use Illuminate\Http\Request;
use App\Utils\ExceptionLogger;

use App\Http\Requests;

use ErrorsManager;

class ErrorsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * The type of error can be defined on the backend constants
     *
     * Current types are: backend, web, mobile
     *
     * @param string $type The type of error
     * @param string $message The error message
     * @param string $stack_trace The stack trace
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ApiValidator::make($request->all(), [
            'type' => 'required|string',
            'message' => 'required|string',
            'stack_trace' => 'required|string'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = ErrorsManager::store($request->all());

            if (!$data) {
                return response()->json(['error' => 'unknown_error_type'], 400);
            }

            return response()->json($data, 201);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }
}
