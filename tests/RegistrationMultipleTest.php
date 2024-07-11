<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\AliasLoader;

class RegistrationMultipleTest extends TestCase
{
    /**
     * {@inheritDoc}
     *
     * @throws BindingResolutionException
     */
    protected function getPackageProviders($app): array
    {
        /** @var Repository $config */
        $config = $app->make('config');

        $config->set(['dev-booter.dev_providers_config_keys.testing' => ['app.dev_providers', 'app.local_providers']]);
        $config->set(['dev-booter.dev_aliases_config_keys.testing' => ['app.dev_aliases', 'app.local_aliases']]);
        $config->set(['app.dev_providers' => [\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider::class]]);
        $config->set(['app.local_providers' => [\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\AnotherDevProvider::class]]);
        $config->set(['app.dev_aliases' => ['Bar' => \PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades\ADevFacade::class]]);
        $config->set(['app.local_aliases' => ['Foo' => \PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades\AnotherDevFacade::class]]);

        return parent::getPackageProviders($app);
    }

    /**
     * Test that when we specify multiple providers by assigning array
     * for config location all the providers are loaded.
     */
    public function test_multiple_providers_by_environment_are_loaded_correctly(): void
    {
        $this->assertArrayHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider', app()->getLoadedProviders());
        $this->assertEquals('dummy.value', $this->app->make('dummy.key'));
        $this->assertInstanceOf(\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Bar::class, $this->app->make('bar'));

        $this->assertArrayHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\AnotherDevProvider', $this->app->getLoadedProviders());
        $this->assertEquals('another-dummy.value', $this->app->make('another-dummy.key'));
        $this->assertInstanceOf(\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Foo::class, $this->app->make('foo'));
    }

    /**
     * Test that when we specify multiple aliases config location
     * per environment all aliases are booted correctly.
     */
    public function test_multiple_aliases_are_loaded_correctly(): void
    {
        $this->assertArrayHasKey('Bar', AliasLoader::getInstance()->getAliases());
        $this->assertArrayHasKey('Foo', AliasLoader::getInstance()->getAliases());
    }
}
