<?php

namespace LaraMonitor\Src\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    protected $signature = 'laramonitor:install';



    protected $description = 'install all of the lara monitor resources';


    public function handle()
    {
        $this->comment('Publish Lara Monitor Config files');
        $this->call('vendor:publish',['--tag' => 'laramonitor-config']);
        $this->comment('Publish Lara Monitor Service Provider');
        $this->registerLaraMonitorServiceProvider();
        $this->comment('Publish Lara Monitor migrations');
        $this->call('vendor:publish', ['--tag'=> 'laramonitor-migrations']);

    }


    public function registerLaraMonitorServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());
        $appConfig = file_get_contents(config_path('app.php'));

        if(Str::contains($appConfig, $namespace.'LaraMonitor\\LaraMonitorServiceProvider')){
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\RouteServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\RouteServiceProvider::class,".PHP_EOL."        LaraMonitor\LaraMonitorServiceProvider::class,".PHP_EOL,
            $appConfig
        ));

    }
}
