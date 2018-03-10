<?php

namespace Managers\Authorization;

use Illuminate\Support\Facades\Facade;

class PermissionsManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PermissionsManager::class;
    }
}
