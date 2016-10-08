## Laravel 5 dev booter

[![Build Status](https://travis-ci.org/percymamedy/laravel-dev-booter.svg?branch=master)](https://travis-ci.org/percymamedy/laravel-dev-booter)
[![StyleCI](https://styleci.io/repos/70182697/shield?branch=master)](https://styleci.io/repos/70182697)
[![Latest Stable Version](https://poser.pugx.org/percymamedy/laravel-dev-booter/v/stable)](https://packagist.org/packages/percymamedy/laravel-dev-booter)
[![Total Downloads](https://poser.pugx.org/percymamedy/laravel-dev-booter/downloads)](https://packagist.org/packages/percymamedy/laravel-dev-booter)
[![Latest Unstable Version](https://poser.pugx.org/percymamedy/laravel-dev-booter/v/unstable)](https://packagist.org/packages/percymamedy/laravel-dev-booter)
[![License](https://poser.pugx.org/percymamedy/laravel-dev-booter/license)](https://packagist.org/packages/percymamedy/laravel-dev-booter)

So many times we find ourselves registering Service Providers that are 
only needed during development in the providers array. This could slow down 
our application by registering providers that we do not need in production.

This packages helps you boost your application by only registring these packages in the
development environments.

### Installation

This packages works for Laravel versions 5.* only.
 
 First install the package using your main ally: composer
 
 ```
 composer require percymamedy/laravel-dev-booter
 ```
 
 Add the Service Provider to your providers array in ```config/app.php```
 
 ```php
 'providers' => [
     ...
     PercyMamedy\LaravelDevBooter\ServiceProvider::class,
 ],
 ```
 
### Configuration and usage

Once installed you can now publish your config file and set your correct configuration for using the package.
 
```php
php artisan vendor:publish --provider="PercyMamedy\LaravelDevBooter\ServiceProvider" --tag="config"
```
 
This will create a file ```config/dev-booter.php```.
 
You may now set your development environments in ```config/dev-booter.php```
 
```php
 'dev_environments' => [
    'local',
    'dev',
    'testing'
 ],
```
 
You can also set where you want your dev ServiceProviders to be loaded from.
 
```php
 'dev_providers_config_key' => 'app.dev_providers'
```
 
Now all you need is to set your Dev ServiceProviders in ```config/app.php``` as you would for regular
ServiceProviders. Except that now there is a clean separation of the two and unwanted ServiceProviders will
not be loaded or registered in your production environment.
 
```php
 'dev_providers' => [
  ...
 ]
```

### Credits

[![Percy Mamedy](https://img.shields.io/badge/Author-Percy%20Mamedy-orange.svg)](https://twitter.com/PercyMamedy)

Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)
<br/>
GitHub: [percymamedy](https://github.com/percymamedy)
 
 
 
 
 
