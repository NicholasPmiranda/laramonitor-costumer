<?php

namespace LaraMonitor\Src\Wachers;

use LaraMonitor\Src\Jobs\Notification\Discord\ExceptionNotificationJob;
use LaraMonitor\Src\Jobs\Server\Exception\SendExceptionJob;
use LaraMonitor\Src\Jobs\Server\Jobs\SendJobFailedJob;
use LaraMonitor\Src\Jobs\Server\Jobs\SendJobProcessedJob;
use LaraMonitor\Src\Jobs\Server\Jobs\SendJobProcessingJob;
use LaraMonitor\Src\Jobs\Server\SendMetricsServerJob;

class WatcherIgnore
{

    public static function jobs()
    {
        return [
            SendMetricsServerJob::class,
            SendJobProcessingJob::class,
            SendJobFailedJob::class,
            SendExceptionJob::class,
            ExceptionNotificationJob::class,
            SendJobProcessedJob::class,
        ];
    }
}
