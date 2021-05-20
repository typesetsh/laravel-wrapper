<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Allowed directories
    |--------------------------------------------------------------------------
    |
    | You must list all directories that typeset.sh can use to load
    | resources such as images, css or font files.
    | By default only the public directory is allowed.
    |
    */

    'allowed_directories' => [
        public_path(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Base directories
    |--------------------------------------------------------------------------
    |
    | The base directory to use for relative paths.
    |
    */

    'base_dir' => public_path(),

    /*
    |--------------------------------------------------------------------------
    | Allowed protocols for downloading
    |--------------------------------------------------------------------------
    |
    | You can prevent downloading any resource from the web or add additional
    | protocols if they are supported by curl.
    |
    */

    'allowed_protocols' => ['http', 'https'],

    /*
    |--------------------------------------------------------------------------
    | Cache directory
    |--------------------------------------------------------------------------
    |
    | Used when downloading resources (images, css, fonts,...) from a remote
    | location.
    |
    */

    'cache_dir' => storage_path('framework/cache/typesetsh'),

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | Max timeout when downloading remote resources. Only works when ext-curl
    | is available.
    |
    */

    'timeout' => 15,

    /*
    |--------------------------------------------------------------------------
    | Download Limit
    |--------------------------------------------------------------------------
    |
    | Max file-size when downloading remote resources. Only works when ext-curl
    | is available.
    |
    */

    'download_limit' => 1024 * 1024 * 5,
];
