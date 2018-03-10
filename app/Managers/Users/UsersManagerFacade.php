<?php

namespace Managers\Users;

use Illuminate\Support\Facades\Facade;

class UsersManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return UsersManager::class;
    }
}
