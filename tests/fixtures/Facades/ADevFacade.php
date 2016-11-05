<?php

namespace TestsFixtures\Facades;

use Illuminate\Support\Facades\Facade;

class ADevFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bar';
    }
}
