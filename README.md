<h2 align="center">
   <img src="https://raw.githubusercontent.com/LaraChimp/art-work/master/packages/dev-booter/dev-booter-art.png"> Laravel dev booter
</h2>

<p align="center">
    <a href="https://packagist.org/packages/percymamedy/laravel-dev-booter"><img src="https://poser.pugx.org/percymamedy/laravel-dev-booter/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/percymamedy/laravel-dev-booter"><img src="https://poser.pugx.org/percymamedy/laravel-dev-booter/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://travis-ci.org/percymamedy/laravel-dev-booter"><img src="https://travis-ci.org/percymamedy/laravel-dev-booter.svg?branch=0.2" alt="Build Status"></a>
    <a href="https://styleci.io/repos/70182697"><img src="https://styleci.io/repos/70182697/shield?branch=0.2" alt="StyleCI"></a>
    <a href="https://packagist.org/packages/percymamedy/laravel-dev-booter"><img src="https://poser.pugx.org/percymamedy/laravel-dev-booter/license" alt="License"></a>
    <a href="https://packagist.org/packages/percymamedy/laravel-dev-booter"><img src="https://poser.pugx.org/percymamedy/laravel-dev-booter/downloads" alt="Total Downloads"></a>
    <a href="https://insight.sensiolabs.com/projects/bc49ef2d-07ea-4bd0-bba0-607386b49004" alt="medal"><img src="https://insight.sensiolabs.com/projects/bc49ef2d-07ea-4bd0-bba0-607386b49004/mini.png"></a>
</p>

## Introduction
During development of a Laravel App; some Service Providers are very helpful. These services helps us with debugging and coding.
But registering these providers on production is usually not a good idea. They can slow down our App or even expose sensitive information.

Laravel Dev Booter helps  end this problem. The package consists of a single ```Service Provider```. 
This provider will exclude unwanted providers from your production environment.

## License
Laravel Dev Booter is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Version Compatibility

 Laravel  | DevBooter
:---------|:----------
 5.x      | 0.2.x
 6.x      | 1.0.x
 7.x      | 2.0.x
 8.x      | 3.0.x
 9.x      | 3.0.x
 10.x     | 4.0.x
 11.x     | 5.0.x
 
### Installation
Install Laravel Dev Booter as you would with any other dependency managed by Composer:

 ```bash
 $ composer require percymamedy/laravel-dev-booter
 ```

### Configuration
> If you are using Laravel >= 5.5, you can skip service registration 
> and aliases registration thanks to Laravel auto package discovery 
> feature.

After installing Laravel Dev Booter all you need is to register the ```PercyMamedy\LaravelDevBooter\ServiceProvider``` 
in your `config/app.php` configuration file:

```php
'providers' => [
    // Other service providers...

    PercyMamedy\LaravelDevBooter\ServiceProvider::class,
],
```

### Usage
First use the ```vendor:publish``` command to copy the configuration file to your application:

 ```bash
$ php artisan vendor:publish --provider="PercyMamedy\LaravelDevBooter\ServiceProvider" --tag="config"
```

This will create the file ```config/dev-booter.php```.

### Defining your development environments
In the file ```config/dev-booter.php``` you will find the ```dev_environments``` section. Use this section
to define your app's development environments:
 
```php
'dev_environments' => [
    'local',
    'dev',
    'testing'
],
```

These are the only environments where Dev Booter will act; and try to register any Service providers.

### Development Service providers locations
The next section in the ```config/dev-booter.php``` file is the ```dev_providers_config_keys```. The array contains an entry
for each of your development environments specified above. Feel free to add and edit this section.

```php
'dev_providers_config_keys' => [
    'dev'     => ['app.dev_providers', 'app.local_providers'],
    'local'   => 'app.local_providers',
    'testing' => 'app.testing_providers',
]
```

The value for each of these entries can be an array or a string. The values represents the locations of a Service Provider array
for each enviroment. You can even specify many locations for an environment, Dev Booter will take care of loading providers in 
each of these locations. 

You may now define these Service Providers array in the ```config/app.php``` file as you would for any regular Service Provider:

```php
'dev_providers' => [
    Foo\Bar\ServiceProvider::class,
],

'local_providers' => [
    Bar\Baz\ServiceProvider::class,
],

'testing_providers' => [
    Foo\Baz\ServiceProvider::class,
],
```

### Development Aliases locations
The last section of the ```config/dev-booter.php``` file is the ```dev_aliases_config_keys```. As with Service Providers, it works
on the same principle.

You first specify the location of your aliases per environment:

```php
'dev_aliases_config_keys' => [
    'dev'     => ['app.dev_aliases', 'app.local_aliases'],
    'local'   => 'app.local_aliases',
    'testing' => 'app.testing_aliases',
]
```

Then define these aliases array in the ```config/app.php``` file:

```php
'dev_aliases' => [
    'Foo' => Foo\Bar\Facade::class,
],

'local_aliases' => [
    'Bar' => Bar\Baz\Facade::class,
],

'testing_aliases' => [
    'Baz' => Foo\Baz\Facade::class,
],
```

### Going Further
In the above examples, providers and aliases array were define in ```config/app.php```, but this does not have to be the case. You
can define these array in any config files provided by Laravel or even create your own. Simply make sure you adjust your 
```dev_providers_config_keys``` and ```dev_aliases_config_keys```.

For example:

```php
'dev_providers_config_keys' => [
    'dev' => ['app_dev.dev_providers', 'app_dev.local_providers'],
    // ...
]
```

Then in ```config/app_dev.php```

```php
'dev_providers' => [
    Foo\Bar\ServiceProvider::class,
],

'local_providers' => [
    Bar\Baz\ServiceProvider::class,
],
```

### Credits
Big Thanks to all developers who worked hard to create something amazing!

### Creator
[![Percy Mamedy](https://img.shields.io/badge/Author-Percy%20Mamedy-orange.svg)](https://twitter.com/PercyMamedy)

Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)
<br/>
GitHub: [percymamedy](https://github.com/percymamedy)
 
 
 
 
 
