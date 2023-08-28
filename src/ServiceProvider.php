<?php

declare(strict_types=1);

namespace PercyMamedy\LaravelDevBooter;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([__DIR__.'/../config/dev-booter.php' => config_path('dev-booter.php')], 'config');

        if ($this->isOnADevEnvironment()) {
            $this->bootDevAliases();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dev-booter.php', 'dev-booter');

        if ($this->isOnADevEnvironment()) {
            $this->registerDevProviders();
        }
    }

    /**
     * Register all dev providers.
     */
    protected function registerDevProviders(): void
    {
        $devProviderKey = 'dev-booter.dev_providers_config_keys.'.$this->app->environment();

        $this
            ->collectDevServiceProviders($devProviderKey)
            ->each(fn ($devServiceProviders) => $this->app->register($devServiceProviders));
    }

    /**
     * Boot all dev class aliases.
     */
    protected function bootDevAliases(): void
    {
        $loader = AliasLoader::getInstance();

        $devProviderKey = 'dev-booter.dev_aliases_config_keys.'.$this->app->environment();

        $this
            ->collectDevAliases($devProviderKey)
            ->each(fn ($facade, $alias) => $loader->alias($alias, $facade));
    }

    /**
     * Check if we are on a dev environment.
     */
    protected function isOnADevEnvironment(): bool
    {
        return $this->collectDevEnvironments()->search($this->app->environment()) !== false;
    }

    /**
     * Return Collection of Dev providers.
     */
    protected function collectDevServiceProviders(string $configKey): Collection
    {
        $devProvidersConfigLocation = Config::get($configKey);

        $keys = is_string($devProvidersConfigLocation) ? [$devProvidersConfigLocation] : $devProvidersConfigLocation;

        return collect($keys)
            ->transform(fn (string $location) => Config::get($location))
            ->filter()
            ->flatten()
            ->unique()
            ->values();
    }

    /**
     * Return Collection of Dev aliases.
     */
    protected function collectDevAliases(string $configKey): Collection
    {
        $devAliasesConfigLocation = Config::get($configKey);

        $keys = is_string($devAliasesConfigLocation) ? [$devAliasesConfigLocation] : $devAliasesConfigLocation;

        return collect($keys)
            ->transform(fn (string $location) => Config::get($location))
            ->filter()
            ->flatMap(fn (mixed $values) => $values)
            ->unique();
    }

    /**
     * Get a Collection of dev environments.
     */
    protected function collectDevEnvironments(): Collection
    {
        return collect(Config::get('dev-booter.dev_environments'));
    }
}
