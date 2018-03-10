<?php

namespace Managers\Notifications;

use Illuminate\Support\Facades\Facade;

class NotificationsManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NotificationsManager::class;
    }
}
