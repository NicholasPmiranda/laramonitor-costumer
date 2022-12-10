<?php

namespace LaraMonitor\Src\Wachers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Queue\Events\QueueBusy;
use Illuminate\Queue\Events\WorkerStopping;
use Illuminate\Queue\Queue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaraMonitor\Src\Actions\JobsAction;

class JobWatcher extends Watcher
{

    public function register(Application $app)
    {
        $app['events']->listen(JobQueued::class, [$this, 'JobQueued']);
        $app['events']->listen(JobProcessing::class, [$this, 'JobProcessing']);
        $app['events']->listen(JobProcessed::class, [$this, 'JobProcessed']);
        $app['events']->listen(JobFailed::class, [$this, 'JobFailed']);
        $app['events']->listen(WorkerStopping::class, [$this, 'WorkerStopping']);
    }

    public function JobQueued(JobQueued $event)
    {

        JobsAction::JobQueued(
            id: $event->id,
            connection_name: $event->connectionName
        );

    }


    public function JobProcessing(JobProcessing $event)
    {

        if(!in_array($event->job->payload()['displayName'], WatcherIgnore::jobs())){
            JobsAction::JobProcessing(
                uuid: $event->job->uuid(),
                name: $event->job->payload()['displayName'],
                attemps: $event->job->attempts(),
                queue_name: $event->job->getQueue(),
            );
        }
    }

    public function JobProcessed(JobProcessed $event)
    {
        if(!in_array($event->job->payload()['displayName'], WatcherIgnore::jobs())) {
            JobsAction::JobProcessed(
                uuid: $event->job->uuid(),
                name: $event->job->payload()['displayName'],
                attemps: $event->job->attempts(),
                queue_name: $event->job->getQueue(),
            );
        }
    }

    public function JobFailed(JobFailed $event)
    {
        if(!in_array($event->job->payload()['displayName'], WatcherIgnore::jobs())) {

            $trace = collect($event->exception->getTrace())->map(function ($item) {
                return Arr::only($item, ['file', 'line']);
            })->toArray();

            JobsAction::JobFailed(
                uuid: strval($event->job->uuid()),
                name: strval($event->job->payload()['displayName']),
                attemps: strval($event->job->attempts()),
                queue_name: strval($event->job->getQueue()),
                exeption_code: strval($event->exception->getCode()),
                exception_file: strval($event->exception->getFile()),
                exeception_line: strval($event->exception->getLine()),
                exeception_message: strval($event->exception->getMessage()),
                exeception_trace: $trace,
            );
        }

    }

    public function WorkerStopping(WorkerStopping $event)
    {
        JobsAction::WorkerStopping(
            status: $event->status
        );
    }


}
