<?php

namespace TestsFixtures\Providers;

use Illuminate\Support\ServiceProvider;
use TestsFixtures\Foo\Foo;

class AnotherDevProvider extends ServiceProvider
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
        $this->app->instance('another-dummy.key', 'another-dummy.value');

        // Bind a dummy class.
        $this->app->bind('foo', function () {
            return new Foo();
        });
    }
}
