<?php

namespace LaraMonitor\Src;

use Illuminate\Foundation\Application;
use LaraMonitor\Src\Traits\RegisterWatchers;
use LaraMonitor\Src\Wachers\HttpClientWatcher;

class LaraMonitor
{
    use RegisterWatchers;
    public static function start(Application $app)
    {
        static::registerWatcher($app);
    }
}
