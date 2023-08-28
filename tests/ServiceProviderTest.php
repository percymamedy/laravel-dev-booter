<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

use Orchestra\Testbench\TestCase;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;

class ServiceProviderTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    public function getPackageProviders($app): array
    {
        return [
            DevBooterProvider::class,
        ];
    }

    /**
     * Test that our config works properly
     * and that we can get desired values
     * from them.
     */
    public function testConfigCanGetValues(): void
    {
        $this->assertEquals([
            'dev'     => 'app.dev_providers',
            'local'   => 'app.local_providers',
            'testing' => 'app.testing_providers',
        ], config('dev-booter.dev_providers_config_keys'));

        $this->assertEquals([
            'dev'     => 'app.dev_aliases',
            'local'   => 'app.local_aliases',
            'testing' => 'app.testing_aliases',
        ], config('dev-booter.dev_aliases_config_keys'));
    }

    /**
     * Test that our config files are being published correctly.
     */
    public function testPublishingOfConfigFile(): void
    {
        $this->artisan('vendor:publish', ['--tag' => 'config']);

        $this->assertFileExists(config_path('dev-booter.php'));

        if (file_exists(config_path('dev-booter.php'))) {
            unlink(config_path('dev-booter.php'));
        }
    }
}
