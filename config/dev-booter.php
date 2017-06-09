<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Development Environments
    |--------------------------------------------------------------------------
    |
    | Here you may define as many development environments as you want.
    | These environments will be used to check if dev packages
    | needs to be registered or not. Go crazy here.
    |
    */

    'dev_environments' => [
        'local',
        'dev',
        'testing',
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Providers config key
    |--------------------------------------------------------------------------
    |
    | Here you may define the config key where you placed all your dev
    | providers. You may define a key for each environment.
    |
    */

    'dev_providers_config_keys' => [
        'dev'     => 'app.dev_providers',
        'local'   => 'app.local_providers',
        'testing' => 'app.testing_providers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Class Aliases
    |--------------------------------------------------------------------------
    |
    | Here you may define the config key where you placed akl your dev class
    | aliases. You may define a key for each environment.
    |
    */

    'dev_aliases_config_keys' => [
        'dev'     => 'app.dev_aliases',
        'local'   => 'app.local_aliases',
        'testing' => 'app.testing_aliases',
    ],
];
