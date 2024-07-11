<?php

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;

class TestCase extends Orchestra
{
    /**
     * {@inheritDoc}
     */
    protected function getPackageProviders($app): array
    {
        return [
            DevBooterProvider::class,
        ];
    }
}
