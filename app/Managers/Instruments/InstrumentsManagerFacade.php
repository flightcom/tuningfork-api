<?php

namespace Managers\Instruments;

use Illuminate\Support\Facades\Facade;

class InstrumentsManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return InstrumentsManager::class;
    }
}
