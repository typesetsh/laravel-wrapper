<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Debug mode
    |--------------------------------------------------------------------------
    |
    | Configuration flag allows you to enable or disable the special view that provides
    | additional information and error logs alongside the PDF in a PDF view.
    |
    | This feature will only work if Laravel's global debug mode is enabled.
    |
    */

    'debug' => true,

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
    | Use public_path() to convert any /some-file.css to your public directory.
    | Use an empty '' string if you prefer absolute paths in your source.
    |
    | Make sure the paths you pick are inside the allowed_directories.
    */

    'base_dir' => '',

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

    /*
    |--------------------------------------------------------------------------
    | Pdf Version
    |--------------------------------------------------------------------------
    |
    | PDF version to save the document in.
    */

    'pdf_version' => '1.6',
];
