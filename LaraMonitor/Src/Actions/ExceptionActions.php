<?php

namespace LaraMonitor\Src\Actions;

use LaraMonitor\Src\Jobs\Notification\Discord\ExceptionNotificationJob;
use LaraMonitor\Src\Jobs\Server\Exception\SendExceptionJob;

class ExceptionActions
{
    public static function store(string $level, string $message, int $line, string $file, array $trace)
    {
        ExceptionNotificationJob::dispatch(
            level: $level,
            message:$message,
            line:$line,
            file:$file,
            request_payload:request()->all(),
            origin:env('APP_NAME')
        );



        SendExceptionJob::dispatch(
            level: $level,
            message:$message,
            line:$line,
            file:$file,
            request_payload:request()->all(),
            origin:env('APP_NAME'),
            trace:$trace
        );
    }
}
