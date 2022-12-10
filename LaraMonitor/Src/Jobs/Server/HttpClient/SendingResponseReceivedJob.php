<?php

namespace LaraMonitor\Src\Jobs\Server\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use LaraMonitor\Src\Helpers\ServerConfig;

class SendingResponseReceivedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $url,
        protected string $method,
        protected array $payload,
        protected array $headers,
        protected string $enviroment,
        protected string $date_time,
        protected array|string $response,
        protected string $response_status,

    ) {

    }

    public function handle()
    {
        $data = [
            'url' => $this->url,
            'method' => $this->method,
            'payload' => $this->payload,
            'headers' => $this->headers,
            'environment' => $this->enviroment,
            'response' => $this->response,
            'response_status' => $this->response_status,
            'auth' => Auth::user()->toArray(),
            'origin_request' => request()->all(),
            'origin' => env('APP_ENV'),
            'sending_at' => $this->date_time
        ];


        $client = new Client();


        $request = $client->post(ServerConfig::HttpClientUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LARA_MONITOR_APP_TOKEN')
            ],
            RequestOptions::JSON => $data
        ]);



    }
}
