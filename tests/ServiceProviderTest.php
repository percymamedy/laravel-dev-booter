<?php

use Orchestra\Testbench\TestCase;

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
        return [\PercyMamedy\LaravelDevBooter\ServiceProvider::class];
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
        $this->assertEquals('app.dev_providers', config('dev-booter.dev_providers_config_key'));
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