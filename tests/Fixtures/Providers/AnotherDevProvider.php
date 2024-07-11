<?php

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers;

use Illuminate\Support\ServiceProvider;
use PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Foo;

class AnotherDevProvider extends ServiceProvider
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
        $this->app->instance('another-dummy.key', 'another-dummy.value');

        $this->app->bind('foo', function () {
            return new Foo();
        });
    }
}
