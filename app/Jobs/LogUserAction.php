<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use ActionLogsManager;

class LogUserAction implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | LogUserAction
    |--------------------------------------------------------------------------
    |
    | When a user performs an action (create, update delete), the action is
    | logged in the database
    |
    */

    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The type of action performed
     *
     * @var $type
     */
    protected $type;

    /**
     * The raw object the action was performed on
     *
     * @var $model
     */
    protected $model;

    /**
     * The class of the model
     *
     * @var $class
     */
    protected $class;

    /**
     * The user that performed the action
     *
     * @var $user
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param $type
     * @param $model
     * @param $class
     * @param $user
     */
    public function __construct(
        $type,
        $model,
        $class,
        $user
    )
    {
        $this->type = $type;
        $this->model = $model;
        $this->class = $class;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $old = null;

        if ($this->type === config('constants.actions_log_type.UPDATED')) {
            $old = serialize($this->model);
        }

        ActionLogsManager::store([
            'user_id' => $this->user ? $this->user->id : null,
            'loggable_id' => $this->model->id,
            'loggable_type' => $this->class,
            'type' => $this->type,
            'old' => $old
        ]);
    }
}
