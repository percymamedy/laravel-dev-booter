<?php

namespace PercyMamedy\LaravelDevBooter\Tests;

use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * Create Dev Application.
     *
     * @param  string  $env
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication($env = 'testing')
    {
        $app = $this->resolveApplication();

        $this->resolveApplicationExceptionHandler($app);
        $this->resolveApplicationCore($app, $env);
        $this->resolveApplicationConfiguration($app);
        $this->resolveApplicationHttpKernel($app);
        $this->resolveApplicationConsoleKernel($app);

        if ($app->version() >= 5.3 && $app->version() < 5.4) {
            $app->make('Illuminate\Foundation\Bootstrap\ConfigureLogging')->bootstrap($app);
        }

        $app->make('Illuminate\Foundation\Bootstrap\HandleExceptions')->bootstrap($app);
        $app->make('Illuminate\Foundation\Bootstrap\RegisterFacades')->bootstrap($app);
        $app->make('Illuminate\Foundation\Bootstrap\SetRequestForConsole')->bootstrap($app);
        $app->make('Illuminate\Foundation\Bootstrap\RegisterProviders')->bootstrap($app);

        $this->getEnvironmentSetUp($app);

        $app->make('Illuminate\Foundation\Bootstrap\BootProviders')->bootstrap($app);

        $app['router']->getRoutes()->refreshNameLookups();

        return $app;
    }

    /**
     * Resolve application core implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  string  $env
     * @return void
     */
    protected function resolveApplicationCore($app, $env = 'testing')
    {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($app);

        $app->detectEnvironment(function () use ($env) {
            return $env;
        });
    }
}
