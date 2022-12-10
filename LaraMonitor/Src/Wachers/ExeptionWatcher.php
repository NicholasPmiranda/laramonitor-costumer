<?php

namespace LaraMonitor\Src\Wachers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Arr;
use LaraMonitor\Src\Actions\ExceptionActions;

class ExeptionWatcher extends Watcher
{
    public function register(Application $app)
    {
        $app['events']->listen(MessageLogged::class, [$this, 'MessageLogged']);
    }

    public function MessageLogged(MessageLogged $event)
    {

        $exeption = $event->context['exception'];

        $trace = collect($exeption->getTrace())->map(function ($item) {
            return Arr::only($item, ['file', 'line']);
        })->toArray();


        ExceptionActions::store(
            level: $event->level,
            message: $event->message,
            line: $exeption->getline(),
            file: $exeption->getFile(),
            trace: $trace
        );

    }
}
