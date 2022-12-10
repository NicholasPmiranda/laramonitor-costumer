<?php


use LaraMonitor\Src\Wachers;

return [

    'conection' => env('LARA_MONITOR_CONECTION', 'server'),

    'notification' => [
        'discord' => [
            'enable' => env('LARA_MONITOR_DISCORD_ENABLE', false),
            'webhook_url' => env('LARA_MONITOR_DISCORD_URL', null,)
        ]
    ],


    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),

    ],


    'watchers' => [
        Wachers\HttpClientWatcher::class => env('LARA_MONITOR_HTTP_CLIENT', true)
    ]

];
