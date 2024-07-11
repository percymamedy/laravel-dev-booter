<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter\Tests;

class ServiceProviderTest extends TestCase
{
    /**
     * Test that our config works properly
     * and that we can get desired values
     * from them.
     */
    public function test_config_can_get_values(): void
    {
        $this->assertEquals([
            'dev' => 'app.dev_providers',
            'local' => 'app.local_providers',
            'testing' => 'app.testing_providers',
        ], config('dev-booter.dev_providers_config_keys'));

        $this->assertEquals([
            'dev' => 'app.dev_aliases',
            'local' => 'app.local_aliases',
            'testing' => 'app.testing_aliases',
        ], config('dev-booter.dev_aliases_config_keys'));
    }

    /**
     * Test that our config files are being published correctly.
     */
    public function test_publishing_of_config_file(): void
    {
        $this->artisan('vendor:publish', ['--tag' => 'config']);

        $this->assertFileExists(config_path('dev-booter.php'));

        if (file_exists(config_path('dev-booter.php'))) {
            unlink(config_path('dev-booter.php'));
        }
    }
}
