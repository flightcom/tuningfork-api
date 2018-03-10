<?php

namespace Managers\Posts;

use Illuminate\Support\Facades\Facade;

class PostsManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PostsManager::class;
    }
}
