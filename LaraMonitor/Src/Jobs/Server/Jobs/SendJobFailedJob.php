<?php

namespace LaraMonitor\Src\Jobs\Server\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaraMonitor\Src\Helpers\ServerConfig;

class SendJobFailedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $uuid,
        protected string $name,
        protected string $attemps,
        protected string $queue_name,
        protected string $exeption_code,
        protected string $exception_file,
        protected string $exeception_line,
        protected string $exeception_message,
        protected array $exeception_trace,
    ) {

        $data = [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'attemps' => $this->attemps,
            'queue_name' => $this->queue_name,
            'exception_code' =>$this->exeption_code,
            'exception_file'=> $this->exception_file,
            'exception_line'=> $this->exeception_line,
            'exception_message'=> $this->exeception_message,
            'exception_trace' => $this->exeception_trace,
            'auth' => \Auth::user(),
            'request'=> request()->all()
        ];


        $client = new Client();
        $client->post(ServerConfig::JobsFailedUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LARA_MONITOR_APP_TOKEN')
            ],
            RequestOptions::JSON => $data
        ]);
    }

    public function handle()
    {

    }
}
