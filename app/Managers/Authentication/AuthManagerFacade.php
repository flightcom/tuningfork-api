<?php

namespace Managers\Authentication;

use Illuminate\Support\Facades\Facade;

class AuthManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AuthManager::class;
    }
}
