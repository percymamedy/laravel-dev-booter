<?php

namespace PercyMamedy\LaravelDevBooter;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish all config files.
        $this->publishes([
            __DIR__ . '/config/dev-booter.php' => config_path('dev-booter.php')
        ], 'config');
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register and Publish Config.
        $this->mergeConfigFrom(
            __DIR__ . '/config/dev-booter.php', 'dev-booter'
        );
        
        // Register all dev providers.
        $this->registerDevProviders();
    }
    
    /**
     * Register all dev providers.
     *
     * @return void
     */
    protected function registerDevProviders()
    {
        // We are on one of the Dev Environments.
        if ($this->mustRegisterDevProviders()) {
            // Register All dev providers.
            $this->collectDevServiceProviders()->each(function ($devServiceProviders) {
                $this->app->register($devServiceProviders);
            });
        }
    }
    
    /**
     * Checks if we must register dev providers.
     *
     * @return bool
     */
    protected function mustRegisterDevProviders()
    {
        return in_array($this->app->environment(), config('dev-booter.dev_environments'));
    }
    
    /**
     * Return list of Dev providers.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function collectDevServiceProviders()
    {
        // Collect Dev providers and return.
        return collect(config(config('dev-booter.dev_providers_config_key')));
    }
}
