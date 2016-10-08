<?php

use Orchestra\Testbench\TestCase;
use PercyMamedy\LaravelDevBooter\ServiceProvider;
use TestsFixtures\Providers\ADevProvider;
use Illuminate\Support\Facades\Facade;

class RegistrationTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    public function getPackageProviders($app)
    {
        config(['app.dev_providers' => [ADevProvider::class]]);

        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Create Dev Application.
     *
     * @param string $env
     *
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

        $app->make('Illuminate\Foundation\Bootstrap\ConfigureLogging')->bootstrap($app);
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
     * @param \Illuminate\Foundation\Application $app
     * @param string                             $env
     *
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

    /**
     * Test that dev providers are registred when on dev env.
     *
     * @return void
     */
    public function testThatDevProvidersAreRegisteredCorrectly()
    {
        $app = $this->createApplication('dev');

        // Package is registered.
        $this->assertTrue(
            array_key_exists(
                'TestsFixtures\Providers\ADevProvider',
                $app->getLoadedProviders()
            )
        );
    }

    /**
     * Test that when we are on production dev providers are
     * not registered.
     *
     * @return void
     */
    public function testThatDevProvidersAreNotRegisteredOnProd()
    {
        $app = $this->createApplication('production');

        $this->assertTrue(
            ! array_key_exists(
                'TestsFixtures\Providers\ADevProvider',
                $app->getLoadedProviders()
            )
        );
    }
}
