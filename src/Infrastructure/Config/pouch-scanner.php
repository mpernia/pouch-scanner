<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for storage, specifying the disk and directories
    | for various types of data in the POUCH system. Users can customize the
    | storage disk, enable/disable storage for requests and images, and define
    | the corresponding directories.
    |
    | Example:
    | 'storage' => [
    |     'disk'         => env('POUCH_STORAGE_DISK', 'local'),
    |     'requests'     => env('POUCH_STORAGE_REQUEST', false),
    |     'requests-dir' => env('POUCH_STORAGE_DIR', 'pouch-scanner-requests'),
    |     'images'       => env('POUCH_STORAGE_IMAGE', false),
    |     'images-dir'   => env('POUCH_STORAGE_IMAGE_DIR', 'pouch-scanner-requests'),
    | ],
    |
    */
    'storage' => [
        'disk'         => env('POUCH_STORAGE_DISK','local'),
        'requests'     => env('POUCH_STORAGE_REQUEST',false),
        'requests-dir' => env('POUCH_STORAGE_DIR','pouch-scanner-requests'),
        'images'       => env('POUCH_STORAGE_IMAGE',false),
        'images-dir'   => env('POUCH_STORAGE_IMAGE_DIR','pouch-scanner-requests')
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Connection Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for an HTTP connection. Specifies the HTTP server
    | details such as host, port, username, and password for the POUCH system.
    |
    | Example:
    | 'connection' => [
    |     'driver'   => 'http',
    |     'host'     => env('POUCH_CONNECTION_HOST', 'localhost'),
    |     'port'     => env('POUCH_CONNECTION_PORT', 80),
    |     'username' => env('POUCH_CONNECTION_USERNAME', 'johndoe'),
    |     'password' => env('POUCH_CONNECTION_PASSWORD', 'secret'),
    | ],
    |
    */
    'connection' => [
        'protocol' => env('POUCH_CONNECTION_PROTOCOL', 'https'),
        'host'     => env('POUCH_CONNECTION_HOST', 'localhost'),
        'port'     => env('POUCH_CONNECTION_PORT', 80),
        'username' => env('POUCH_CONNECTION_USERNAME', 'johndoe'),
        'password' => env('POUCH_CONNECTION_PASSWORD', 'secret'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guzzle Configuration
    |--------------------------------------------------------------------------
    |    - verb, the default http verb to use.
    |    - headers, these are the headers that will be added to all requests.
    |    - exceptions, set to false to disable throwing exceptions on an HTTP protocol
    |      errors (i.e., 4xx and 5xx responses). Exceptions are thrown by default when
    |      HTTP protocol errors are encountered.
    |    - timeout, if a call to a request takes longer that this number of seconds
    |      the attempt will be considered failed.
    |    - tries, the number of times the request should be called before we give up.
    |    - max_exceptions, the maximum number of exceptions to allow before failing.
    |    - verify_ssl, by default we will not verify that the ssl certificate of the
    |      destination of the request is valid.
    |
    | Example:
    | 'http' => [
    |     'verb'            => env('HTTP_CLIENT_DEFAULT_VERB', 'GET'),
    |     'headers'         => ['Content-Type' => 'application/xml'],
    |     'exceptions'      => false,
    |     'timeout'         => env('HTTP_CLIENT_DEFAULT_TIMEOUT', 3),
    |     'tries'           => env('HTTP_CLIENT_DEFAULT_TRIES', 3),
    |     'max_exceptions'  => env('HTTP_CLIENT_DEFAULT_MAX_EXCEPTIONS', 3),
    |     'verify_ssl'      => env('HTTP_CLIENT_DEFAULT_VERIFY_SSL', false),
    | ],
    |
    */
   'http' => [
       'verb' => env('HTTP_CLIENT_DEFAULT_VERB', 'GET'),
        'headers' => ['Content-Type' => 'application/xml'],
        'exceptions' => false,
        'timeout' => env('HTTP_CLIENT_DEFAULT_TIMEOUT', 3),
        'tries'  => env('HTTP_CLIENT_DEFAULT_TRIES',  3),
        'max_exceptions'  => env('HTTP_CLIENT_DEFAULT_MAX_EXCEPTIONS',  3),
        'verify_ssl'  => env('HTTP_CLIENT_DEFAULT_VERIFY_SSL',  false),
    ],
];

