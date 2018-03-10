<?php

namespace Managers\System;

use Models\Error;
use Log;

class ErrorsManager
{
    /*
    |--------------------------------------------------------------------------
    | ErrorsManager
    |--------------------------------------------------------------------------
    |
    | The ErrorsManager is simply the business logic between the controller and
    | the model.
    |
    | The purpose of this model is to store and display system errors. This
    | should not be integrated with the other regular entities on the frontend
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return Error::paginate();
    }

    /**
     * This store function is used to log errors in the database.
     * The errors stored will be viewable from the admin panel for easy
     * debugging. Should the error log fail to store to the database, it means
     * the problem might be critical. The error will be logged in the regular
     * log file if this should happen.
     *
     * If the error type provided is not defined in the config constants,
     * null will be returned and the entry will not be logged
     *
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        if (!array_key_exists($data['type'], config('constants.error_type'))) {
            return null;
        }

        try {
            return Error::create([
                'type'          => $data['type'],
                'message'           => $data['message'],
                'stack_trace'       => $data['stack_trace'],
            ]);
        } catch (Exception $e) {
            Log::critical('Unable to store error in the database');
            Log::critical('Error received while trying to store in database:');
            Log::critical($e->getMessage());
            Log::critical($e->getTraceAsString());
            Log::critical('Error attempted to store for type ' . $data['type']);
            Log::critical($data['message']);
            Log::critical($data['stack_trace']);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Error::find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return Error::destroy($id);
    }
}
