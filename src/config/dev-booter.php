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
    | providers the default is "app.dev_providers", but feel free
    | to change this value if you want to.
    |
    */
    
    'dev_providers_config_key' => 'app.dev_providers',
    
    /*
    |--------------------------------------------------------------------------
    | Development Class Aliases
    |--------------------------------------------------------------------------
    |
    | Here you may define the config key where you placed akl your dev class
    | aliases. The default is "app.dev_aliases", but again you are free
    | to choose where to place them.
    |
    */
    
    'dev_aliases_config_key' => 'app.dev_aliases'
];
