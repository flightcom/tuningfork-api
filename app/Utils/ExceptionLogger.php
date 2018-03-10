<?php

namespace App\Utils;

use ErrorsManager;
use Log;
use Exception;

class ExceptionLogger {

    /**
     * To avoid duplicating code within controllers as well as
     * handling ALL exceptions in the "Handler" since it doesn't
     * really care whether the exception happened from the api or
     * because of a typo, use this helper to save the exception when
     * it is appropriate
     *
     * This should only really be used to store system wide errors
     * that we can later see on the admin panel and track down.
     *
     * @param Exception $exception
     */
    public static function log(Exception $exception)
    {
        ErrorsManager::store([
            'type' => 'backend',
            'message' => $exception->getMessage(),
            'stack_trace' => $exception->getTraceAsString()
        ]);
    }

    /**
     * When an invalid ID is sent for a show, update or delete,
     * a ModelNotFound exception is thrown. Unfortunately by default
     * the response status is 500 instead of 404. For this reason,
     * we must manually check if indeed the model could not be found.
     *
     * In order to centralize the response and provide an error message
     * that is similar from all controllers, use this function.
     *
     * It will generate a response that returns ['error' => '$model_not_found']
     * where $model is the string passed as an argument
     *
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     */
    public static function apiReturnModelNotFound($model)
    {
        return response()->json(['error' => $model . '_not_found'], 404);
    }
}
