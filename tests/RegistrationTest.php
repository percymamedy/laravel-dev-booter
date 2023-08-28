<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

use Illuminate\Foundation\AliasLoader;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;

class RegistrationTest extends AbstractTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    public function getPackageProviders($app): array
    {
        config(['app.dev_providers' => [\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider::class]]);
        config(['app.dev_aliases' => ['Bar' => \PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades\ADevFacade::class]]);

        return [
            DevBooterProvider::class,
        ];
    }

    /**
     * Test that dev providers are registered when on dev env.
     */
    public function testThatDevProvidersAreRegisteredCorrectly(): void
    {
        $app = $this->createApplication('dev');

        $this->assertArrayHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider', $app->getLoadedProviders());
        $this->assertEquals('dummy.value', $app->make('dummy.key'));
        $this->assertInstanceOf(\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Bar::class, $app->make('bar'));
    }

    /**
     * Test that dev class aliases are properly booter.
     */
    public function testThatClassAliasesAreBootedCorrectly(): void
    {
        $this->createApplication('dev');

        $this->assertArrayHasKey('Bar', AliasLoader::getInstance()->getAliases());
    }

    /**
     * Test that when we are on production dev providers are
     * not registered.
     */
    public function testThatDevProvidersAreNotRegisteredOnProd(): void
    {
        $app = $this->createApplication('production');

        $this->assertArrayNotHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider', $app->getLoadedProviders());
    }
}
