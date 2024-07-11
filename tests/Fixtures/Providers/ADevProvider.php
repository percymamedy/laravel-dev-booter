<?php

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers;

use Illuminate\Support\ServiceProvider;
use PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Bar;

class ADevProvider extends ServiceProvider
{
    /**
     * Boot Application Services.
     */
    public function boot(): void {}

    /**
     * Register Application Services.
     */
    public function register(): void
    {
        $this->app->instance('dummy.key', 'dummy.value');

        $this->app->bind('bar', function () {
            return new Bar();
        });
    }
}
