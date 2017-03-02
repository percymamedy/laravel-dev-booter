<?php

use Illuminate\Foundation\AliasLoader;
use TestsFixtures\Providers\ADevProvider;
use TestsFixtures\Providers\AnotherDevProvider;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;

class RegistrationMultipleTest extends AbstractTestCase
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
        config(['dev-booter.dev_providers_config_keys.dev' => ['app.dev_providers', 'app.local_providers']]);
        config(['dev-booter.dev_aliases_config_keys.dev' => ['app.dev_aliases', 'app.local_aliases']]);
        config(['app.dev_providers' => [ADevProvider::class]]);
        config(['app.local_providers' => [AnotherDevProvider::class]]);
        config(['app.dev_aliases' => ['Bar' => \TestsFixtures\Facades\ADevFacade::class]]);
        config(['app.local_aliases' => ['Foo' => \TestsFixtures\Facades\AnotherDevFacade::class]]);

        return [
            DevBooterProvider::class,
        ];
    }

    /**
     * Test that when we specify multiple providers by assingning array
     * for config location all of the providers are loaded.
     *
     * @return void
     */
    public function testMultipleProvidersByEnvironmentAreLoadedCorrectly()
    {
        $app = $this->createApplication('dev');

        $this->assertTrue(array_key_exists('TestsFixtures\Providers\ADevProvider', $app->getLoadedProviders()));
        $this->assertEquals('dummy.value', $app->make('dummy.key'));
        $this->assertInstanceOf(\TestsFixtures\Foo\Bar::class, $app->make('bar'));

        $this->assertTrue(array_key_exists('TestsFixtures\Providers\AnotherDevProvider', $app->getLoadedProviders()));
        $this->assertEquals('another-dummy.value', $app->make('another-dummy.key'));
        $this->assertInstanceOf(\TestsFixtures\Foo\Foo::class, $app->make('foo'));
    }

    /**
     * Test that when we specify multiple aliases config location
     * per environment all aliases are booted correctly.
     *
     * @return void
     */
    public function testMultipleAliasesAreLoadedCorrectly()
    {
        $app = $this->createApplication('dev');

        $this->assertTrue(array_key_exists('Bar', AliasLoader::getInstance()->getAliases()));
        $this->assertTrue(array_key_exists('Foo', AliasLoader::getInstance()->getAliases()));
    }
}
