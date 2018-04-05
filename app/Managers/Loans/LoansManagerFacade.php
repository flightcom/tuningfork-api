<?php

namespace Managers\Loans;

use Illuminate\Support\Facades\Facade;

class LoansManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LoansManager::class;
    }
}
