<?php

namespace Managers\Files;

use Illuminate\Support\Facades\Facade;

class FilesManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FilesManager::class;
    }
}
