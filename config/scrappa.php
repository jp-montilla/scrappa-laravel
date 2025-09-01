<?php

// config for John Paul Montilla/Scrappa
return [
    /*
    |--------------------------------------------------------------------------
    | Scrappa API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Scrappa API settings. You can set your
    | API key and base URL for the Scrappa service.
    |
    */

    'api_key' => env('SCRAPPA_API_KEY', ''),

    'base_url' => env('SCRAPPA_BASE_URL', 'https://app.scrappa.co/api'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout for HTTP requests in seconds.
    |
    */

    'timeout' => env('SCRAPPA_TIMEOUT', 30),


];
