<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

class WithoutProvidersRegistrationTest extends TestCase
{
    /**
     * Test that when we are on production dev providers are not registered.
     */
    public function test_that_dev_providers_are_not_registered(): void
    {
        $this->assertArrayNotHasKey('PercyMamedy\LaravelDevBooter\Tests\Fixtures\Providers\ADevProvider', $this->app->getLoadedProviders());
    }
}
