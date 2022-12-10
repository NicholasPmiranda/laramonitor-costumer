<?php

namespace LaraMonitor\Src\Traits;

use Illuminate\Foundation\Application;

trait RegisterWatchers
{
    protected static $watchers = [];

    protected static function registerWatcher(Application $app)
    {

        foreach (config('laramonitor.watchers') as $key => $watcher) {
            if (is_string($key) && $watcher === false) {
                continue;
            }

            $watcher = $app->make(is_string($key) ? $key : $watcher, [
                'options' => is_array($watcher) ? $watcher : [],
            ]);

            static::$watchers[] = get_class($watcher);

            $watcher->register($app);

        }
    }
}
