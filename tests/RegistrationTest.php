<?php

use Illuminate\Foundation\AliasLoader;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;
use TestsFixtures\Providers\ADevProvider;

class RegistrationTest extends AbstractTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        config(['app.dev_providers' => [ADevProvider::class]]);
        config(['app.dev_aliases' => ['Bar' => \TestsFixtures\Facades\ADevFacade::class]]);

        return [
            DevBooterProvider::class,
        ];
    }

    /**
     * Test that dev providers are registered when on dev env.
     *
     * @return void
     */
    public function testThatDevProvidersAreRegisteredCorrectly()
    {
        $app = $this->createApplication('dev');

        // Package is registered.
        $this->assertTrue(array_key_exists('TestsFixtures\Providers\ADevProvider', $app->getLoadedProviders()));
        $this->assertEquals('dummy.value', $app->make('dummy.key'));
        $this->assertInstanceOf(\TestsFixtures\Foo\Bar::class, $app->make('bar'));
    }

    /**
     * Test that dev class aliases are properly booter.
     *
     * @return void
     */
    public function testThatClassAliasesAreBootedCorrectly()
    {
        $this->createApplication('dev');

        $this->assertTrue(array_key_exists('Bar', AliasLoader::getInstance()->getAliases()));
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

        $this->assertTrue(! array_key_exists('TestsFixtures\Providers\ADevProvider', $app->getLoadedProviders()));
    }
}
