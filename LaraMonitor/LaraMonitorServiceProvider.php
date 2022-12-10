<?php

namespace LaraMonitor;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Support\ServiceProvider;
use LaraMonitor\Src\Console\InstallCommand;
use LaraMonitor\Src\LaraMonitor;

class LaraMonitorServiceProvider extends ServiceProvider
{

    public function boot(Application $app)
    {

        $this->commands([
            InstallCommand::class
        ]);

        $this->publishes([
            __DIR__ . '/src/config/laramonitor.php' =>config_path('laramonitor.php')
        ],'laramonitor-config');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'laramonitor-migrations');


        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        LaraMonitor::start($app);
    }




    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/src/config/laramonitor.php', 'laramonitor');
    }
}
