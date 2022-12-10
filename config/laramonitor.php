<?php


use LaraMonitor\Src\Wachers;

return [


    'notification' => [
        'discord' => [
            'enable' => env('LARA_MONITOR_DISCORD_ENABLE', false),
            'webhook_url' => env('LARA_MONITOR_DISCORD_URL', null,)
        ]
    ],





    'watchers' => [
        Wachers\HttpClientWatcher::class => env('LARA_MONITOR_HTTP_CLIENT', true),
        Wachers\JobWatcher::class =>env('LARA_MONITOR_JOB', true),
        Wachers\ExeptionWatcher::class =>env('LARA_MONITOR_EXEPTION', true),
    ]

];
