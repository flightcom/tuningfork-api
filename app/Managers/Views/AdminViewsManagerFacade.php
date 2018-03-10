<?php

namespace Managers\Views;

use Illuminate\Support\Facades\Facade;

class AdminViewsManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AdminViewsManager::class;
    }
}
