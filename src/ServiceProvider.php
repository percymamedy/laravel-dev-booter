<?php

namespace PercyMamedy\LaravelDevBooter;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\AliasLoader;

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
            __DIR__ . '/config/dev-booter.php' => config_path('dev-booter.php'),
        ], 'config');

        // We are on one of the dev environment
        if ($this->isOnADevEnvironment()) {
            // Boot dev class aliases.
            $this->bootDevAliases();
        }
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

        // We are on one of the Dev Environments.
        if ($this->isOnADevEnvironment()) {
            // Register all dev providers.
            $this->registerDevProviders();
        }
    }

    /**
     * Register all dev providers.
     *
     * @return void
     */
    protected function registerDevProviders()
    {
        // Register All dev providers.
        $this->collectDevServiceProviders()->each(function ($devServiceProviders) {
            $this->app->register($devServiceProviders);
        });
    }

    /**
     * Boot all dev class aliases.
     *
     * @return void
     */
    protected function bootDevAliases()
    {
        //Get the instance of the alias loader
        $loader = AliasLoader::getInstance();

        // Boot all classes Aliases.
        $this->collectDevAliases()->each(function ($facade, $alias) use ($loader) {
            $loader->alias($alias, $facade);
        });
    }

    /**
     * Check if we are on a dev environment.
     *
     * @return bool
     */
    protected function isOnADevEnvironment()
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

    /**
     * Return list of Dev aliases.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function collectDevAliases()
    {
        // Collect Dev Aliases and return them.
        return collect(config(config('dev-booter.dev_aliases_config_key')));
    }
}
