<?php

namespace TestsFixtures\Providers;

use TestsFixtures\Foo\Bar;
use Illuminate\Support\ServiceProvider;

class ADevProvider extends ServiceProvider
{
    /**
     * Boot Application Services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register Application Services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('dummy.key', 'dummy.value');

        // Bind a dummy class.
        $this->app->bind('bar', function () {
            return new Bar();
        });
    }
}
