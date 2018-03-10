<?php

namespace Managers\System;

use Illuminate\Support\Facades\Facade;

class ErrorsManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ErrorsManager::class;
    }
}
