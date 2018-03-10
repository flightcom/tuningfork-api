<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

use Auth;

class UserModelAction
{
    use InteractsWithSockets, SerializesModels;

    /**
     * The type of action that is being logged
     * Created, Updated, Deleted
     *
     * @var $type
     */
    protected $type;

    /**
     * The model that the action was taken on
     *
     * @var $model
     */
    protected $model;

    /**
     * The user who performed the action
     *
     * @var $user
     */
    protected $user;

    /**
     * Create a new event instance.
     *
     * @param $type
     * @param $model
     */
    public function __construct($type, $model)
    {
        $this->type = $type;
        $this->model = $model;
        $this->user = Auth::user();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * Returns the type of action that is being logged
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the model that the action was taken on
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns the user that performed the action
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}
