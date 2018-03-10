<?php

namespace App\Utils;

use Validator;

class ApiValidator {

    /**
     * This class is a wrapper around the regular Laravel
     * Validator.
     *
     * Its purpose is to make use of api friendly validation
     * messages that can be checked on the front end rather
     * than sending the message directly since the front
     * end is the platform that deals with localization
     *
     * Asside from making the Validator object, it will also
     * validate and format the rules to be frontend friendly
     *
     * @param array $data
     * @param array $rules
     * @return Validator
     */

    /**
     * @var validator The Validator instance
     */
    protected static $validator;

    /**
     * Given the data and the rules, this function will create a
     * Validator instance and store it in a class variable. This
     * class uses custom api validation messages defined in the
     * config.
     *
     * @param array $data
     * @param array $rules
     */
    public static function make(array $data, array $rules)
    {
        ApiValidator::$validator = Validator::make($data, $rules, config('api-validation'));
    }

    /**
     * Returns true if the validation fails
     *
     * @return mixed
     */
    public static function fails()
    {
        return ApiValidator::$validator->fails();
    }

    /**
     * Frontend friendly json response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response()
    {
        return response()->json([
            'errors' => ApiValidator::$validator->errors()
        ], 400);
    }
}
