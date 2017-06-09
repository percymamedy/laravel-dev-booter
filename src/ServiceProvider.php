<?php

namespace PercyMamedy\LaravelDevBooter;

use Illuminate\Support\Collection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
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
        $this->publishes([__DIR__.'/../config/dev-booter.php' => config_path('dev-booter.php')], 'config');

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
        $this->mergeConfigFrom(__DIR__.'/../config/dev-booter.php', 'dev-booter');

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
        // Get Dev providers key.
        $devProviderKey = 'dev-booter.dev_providers_config_keys.'.$this->app->environment();

        // Register All dev providers.
        $this->collectDevServiceProviders($devProviderKey)->each(function ($devServiceProviders) {
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

        // Get Dev class aliases config key.
        $devProviderKey = 'dev-booter.dev_aliases_config_keys.'.$this->app->environment();

        // Boot all classes Aliases.
        $this->collectDevAliases($devProviderKey)->each(function ($facade, $alias) use ($loader) {
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
        return $this->collectDevEnvironments()->search($this->app->environment()) !== false;
    }

    /**
     * Return Collection of Dev providers.
     *
     * @param string $configKey
     *
     * @return Collection
     */
    protected function collectDevServiceProviders($configKey)
    {
        // Get the Config key where devProviders are located.
        $devProvidersConfigLocation = Config::get($configKey);

        // Get Providers keys.
        $keys = is_string($devProvidersConfigLocation) ? [$devProvidersConfigLocation] : $devProvidersConfigLocation;

        // Return Dev Providers.
        return collect($keys)->transform(function ($location) {
            // Transform each Location key to the actual array
            // containing the Providers.
            return Config::get($location);
        })->reject(function ($arrayOfProviders) {
            // Remove all null values
            return is_null($arrayOfProviders);
        })->flatten()->unique()->values();
    }

    /**
     * Return Collection of Dev aliases.
     *
     * @param string $configKey
     *
     * @return Collection
     */
    protected function collectDevAliases($configKey)
    {
        // Get the Config key where dev aliases are located.
        $devAliasesConfigLocation = Config::get($configKey);

        // Get Aliases keys.
        $keys = is_string($devAliasesConfigLocation) ? [$devAliasesConfigLocation] : $devAliasesConfigLocation;

        return collect($keys)->transform(function ($location) {
            // Transform each Location key to the actual array
            // containing the Aliases.
            return Config::get($location);
        })->reject(function ($arrayOfProviders) {
            // Remove all null values
            return is_null($arrayOfProviders);
        })->flatMap(function ($values) {
            return $values;
        })->unique();
    }

    /**
     * Get a Collection of dev environments.
     *
     * @return Collection
     */
    protected function collectDevEnvironments()
    {
        return collect(Config::get('dev-booter.dev_environments'));
    }
}
