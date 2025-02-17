<?php
$config['app'] = [
    'service' => [

    ],
    'routeMiddleware' => [
        'dang-nhap' => AuthMiddleware::class,
        'signin/login' => AuthMiddleware::class
    ],
    'globalMiddleware' => [

    ],
    'boot' => [
        AppServiceProvider::class,
    ],
];
