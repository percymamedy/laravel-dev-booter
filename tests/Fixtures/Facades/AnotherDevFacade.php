<?php

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades;

use Illuminate\Support\Facades\Facade;

class AnotherDevFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'foo';
    }
}
