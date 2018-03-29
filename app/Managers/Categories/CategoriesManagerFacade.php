<?php

namespace Managers\Categories;

use Illuminate\Support\Facades\Facade;

class CategoriesManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CategoriesManager::class;
    }
}
