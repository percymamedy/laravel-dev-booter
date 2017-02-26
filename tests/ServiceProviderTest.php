<?php

use Orchestra\Testbench\TestCase;
use PercyMamedy\LaravelDevBooter\ServiceProvider as DevBooterProvider;

class ServiceProviderTest extends TestCase
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
        return [DevBooterProvider::class];
    }

    /**
     * Test that our config works properly
     * and that we can get desired values
     * from them.
     *
     * @return void
     */
    public function testConfigCanGetValues()
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
     *
     * @return void
     */
    public function testPublishingOfConfigFile()
    {
        // Publish config.
        $this->artisan('vendor:publish', ['--tag' => 'config']);

        // File must be there
        $this->assertFileExists(config_path('dev-booter.php'));

        // Delete config files
        if (file_exists(config_path('dev-booter.php'))) {
            unlink(config_path('dev-booter.php'));
        }
    }
}
