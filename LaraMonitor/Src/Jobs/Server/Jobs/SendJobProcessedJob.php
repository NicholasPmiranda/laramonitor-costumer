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

class SendJobProcessedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $uuid
    ) {

    }

    public function handle()
    {

        $data = [
            'uuid' => $this->uuid,
        ];

        $client = new Client();
        $client->post(ServerConfig::JobsProcessedUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LARA_MONITOR_APP_TOKEN')
            ],
            RequestOptions::JSON => $data
        ]);
    }
}
