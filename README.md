# Laravel 5 dev booter

So many times we find ourselves registering Service Providers that are 
only needed during development in the providers array. This could slow down 
our application by registering providers that we do not need in production.

This packages helps you boost your application by only registring these packages in the
development environments.

## Installation

This packages works for Laravel versions 5.* only.
 
 First install the package using your main ally: composer
 ```
 composer require percymamedy/laravel-dev-booter
 ```
 
