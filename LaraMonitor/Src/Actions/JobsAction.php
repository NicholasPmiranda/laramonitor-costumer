<?php

namespace LaraMonitor\Src\Actions;

use LaraMonitor\Src\Jobs\Server\Jobs\SendJobFailedJob;
use LaraMonitor\Src\Jobs\Server\Jobs\SendJobProcessedJob;
use LaraMonitor\Src\Jobs\Server\Jobs\SendJobProcessingJob;

class JobsAction
{

    public static function JobQueued(string $id, string $connection_name)
    {

    }

    public static function JobProcessing(string $uuid, string $name, string $attemps, string $queue_name)
    {
        SendJobProcessingJob::dispatch(
            uuid: $uuid,
            name: $name,
            attemps: $attemps,
            queue_name: $queue_name,
        );
    }

    public static function JobProcessed(string $uuid, string $name, string $attemps, string $queue_name)
    {
        SendJobProcessedJob::dispatch(uuid:$uuid);

    }

    public static function JobFailed(
        string $uuid,
        string $name,
        string $attemps,
        string $queue_name,
        string $exeption_code,
        string $exception_file,
        string $exeception_line,
        string $exeception_message,
        array $exeception_trace,
    )
    {
        SendJobFailedJob::dispatch(
            uuid: $uuid,
            name: $name,
            attemps: $attemps,
            queue_name: $queue_name,
            exeption_code: $exeption_code,
            exception_file: $exception_file,
            exeception_line:$exeception_line,
            exeception_message: $exeception_message,
            exeception_trace: $exeception_trace,
        );
    }

    public static function WorkerStopping(string $status)
    {

    }
}
