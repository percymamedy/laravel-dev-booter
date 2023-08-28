<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

use Illuminate\Foundation\AliasLoader;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;

class RegistrationMultipleTest extends AbstractTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    public function getPackageProviders($app): array
    {
        config(['dev-booter.dev_providers_config_keys.dev' => ['app.dev_providers', 'app.local_providers']]);
        config(['dev-booter.dev_aliases_config_keys.dev' => ['app.dev_aliases', 'app.local_aliases']]);
        config(['app.dev_providers' => [\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider::class]]);
        config(['app.local_providers' => [\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\AnotherDevProvider::class]]);
        config(['app.dev_aliases' => ['Bar' => \PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades\ADevFacade::class]]);
        config(['app.local_aliases' => ['Foo' => \PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades\AnotherDevFacade::class]]);

        return [
            DevBooterProvider::class,
        ];
    }

    /**
     * Test that when we specify multiple providers by assingning array
     * for config location all of the providers are loaded.
     */
    public function testMultipleProvidersByEnvironmentAreLoadedCorrectly(): void
    {
        $app = $this->createApplication('dev');

        $this->assertArrayHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider', $app->getLoadedProviders());
        $this->assertEquals('dummy.value', $app->make('dummy.key'));
        $this->assertInstanceOf(\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Bar::class, $app->make('bar'));

        $this->assertArrayHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\AnotherDevProvider', $app->getLoadedProviders());
        $this->assertEquals('another-dummy.value', $app->make('another-dummy.key'));
        $this->assertInstanceOf(\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Foo::class, $app->make('foo'));
    }

    /**
     * Test that when we specify multiple aliases config location
     * per environment all aliases are booted correctly.
     */
    public function testMultipleAliasesAreLoadedCorrectly(): void
    {
        $this->createApplication('dev');

        $this->assertArrayHasKey('Bar', AliasLoader::getInstance()->getAliases());
        $this->assertArrayHasKey('Foo', AliasLoader::getInstance()->getAliases());
    }
}
