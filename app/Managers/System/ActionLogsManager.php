<?php

namespace Managers\System;

use Models\ActionLog;
use Gate;

class ActionLogsManager
{
    /*
    |--------------------------------------------------------------------------
    | ActionLogsManager
    |--------------------------------------------------------------------------
    |
    | The ActionLogsManager is simply the business logic between the controller
    | and the model.
    |
    | The purpose of this model is to keep track of user actions such as
    | creating, updating and deleting models. This should not be integrated with
    | the other regular entities on the frontend
    |
    */

    /**
     * @return mixed
     */
    public function query($modelId, $modelType, $perPage = 15)
    {
        return ActionLog::where([
            'loggable_id' => $modelId,
            'loggable_type' => $modelType
        ])->with('user')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * This store function is used to user actions in the database.
     * The actions stored will be viewable from the admin panel.
     *
     * If the action type provided is not defined in the config constants,
     * null will be returned and the entry will not be logged
     *
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        if (!array_key_exists($data['type'], config('constants.actions_log_type'))) {
            return null;
        }

        try {
            return ActionLog::create([
                'user_id' => $data['user_id'],
                'loggable_id' => $data['loggable_id'],
                'loggable_type' => $data['loggable_type'],
                'type' => $data['type'],
                'old' => $data['old']
            ]);
        } catch (Exception $e) {
            Log::critical('Unable to store action log in the database');
        }
    }
}
