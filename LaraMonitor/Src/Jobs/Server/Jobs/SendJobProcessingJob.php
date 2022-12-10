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

class SendJobProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $uuid,
        protected string $name,
        protected string $attemps,
        protected string $queue_name
    ) {

    }

    public function handle()
    {

        $data = [
            'uuid' => $this->uuid,
            'name'=> $this->name,
            'attemps'=> $this->attemps,
            'queue_name' => $this->queue_name,
            'env'=> env('APP_ENV'),
            'origin'=> env('APP_NAME')
        ];

        $client = new Client();
        $client->post(ServerConfig::JobsUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LARA_MONITOR_APP_TOKEN')
            ],
            RequestOptions::JSON => $data
        ]);
    }
}
