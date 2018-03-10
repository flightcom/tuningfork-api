<?php

namespace App\Listeners;

use App\Events\UserModelAction;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Container\Container as App;

use App\Jobs\LogUserAction;
use Illuminate\Foundation\Bus\DispatchesJobs;

class LogUserModelAction implements ShouldQueue
{

    use DispatchesJobs;

    /**
     * The app instance
     *
     * @var $app
     */
    protected $app;

    /**
     * Create a new event instance.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Handle the event.
     *
     * @param  UserModelAction  $event
     * @return void
     */
    public function handle(UserModelAction $event)
    {
        $model = $event->getModel();

        $this->dispatch(new LogUserAction(
            $event->getType(),
            $model,
            get_class($model),
            $event->getUser()
        ));
    }
}
