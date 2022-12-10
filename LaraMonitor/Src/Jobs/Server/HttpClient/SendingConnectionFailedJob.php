<?php

namespace LaraMonitor\Src\Jobs\Server\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaraMonitor\Src\Helpers\ServerConfig;

class SendingConnectionFailedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $url,
        protected string $method,
        protected array $payload,
        protected array $headers,
        protected string $enviroment,
        protected string $date_time,
        protected array|null $auth,
        protected array|null $origin_request
    ) {

    }

    public function handle()
    {
        $data = [
            'url' => $this->url,
            'method' => $this->method,
            'payload' => $this->payload,
            'headers' => $this->headers,
            'environment' => env('APP_ENV'),
            'date_time' => $this->date_time,
            'auth' => $this->auth,
            'origin' => env('APP_NAME'),
            'origin_request' => $this->origin_request,
            'sending_at' => $this->date_time,
            'response' => 'not connect'
        ];


        $client = new Client();
        $client->post(ServerConfig::HttpClientUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LARA_MONITOR_APP_TOKEN')
            ],
            RequestOptions::JSON => $data
        ]);
    }
}
