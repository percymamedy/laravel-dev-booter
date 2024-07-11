<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\AliasLoader;

class RegistrationTest extends TestCase
{
    /**
     * {@inheritDoc}
     *
     * @throws BindingResolutionException
     */
    public function getPackageProviders($app): array
    {
        /** @var Repository $config */
        $config = $app->make('config');

        $config->set(['app.testing_providers' => [\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider::class]]);
        $config->set(['app.testing_aliases' => ['Bar' => \PercyMamedy\LaravelDevBooter\Tests\Fixtures\Facades\ADevFacade::class]]);

        return parent::getPackageProviders($app);
    }

    /**
     * Test that dev providers are registered when on dev env.
     *
     * @throws BindingResolutionException
     */
    public function test_that_dev_providers_are_registered_correctly(): void
    {
        $this->assertArrayHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider', $this->app->getLoadedProviders());
        $this->assertEquals('dummy.value', $this->app->make('dummy.key'));
        $this->assertInstanceOf(\PercyMamedy\LaravelDevBooter\Tests\Fixtures\Foo\Bar::class, $this->app->make('bar'));
    }

    /**
     * Test that dev class aliases are properly booter.
     */
    public function test_that_class_aliases_are_booted_correctly(): void
    {
        $this->assertArrayHasKey('Bar', AliasLoader::getInstance()->getAliases());
    }
}
