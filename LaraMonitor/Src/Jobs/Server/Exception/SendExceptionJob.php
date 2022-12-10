<?php

namespace LaraMonitor\Src\Jobs\Server\Exception;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use LaraMonitor\Src\Helpers\ServerConfig;

class SendExceptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $level,
        protected string $message,
        protected string $file,
        protected int $line,
        protected array $request_payload,
        protected string $origin,
        protected array $trace
    ) {
    }

    public function handle()
    {
        $data = [
            'level' => $this->level,
            'message' => $this->message,
            'file' => $this->file,
            'line' => $this->line,
            'request_payload' => $this->request_payload,
            'origin' => $this->origin,
            'auth' => Auth::user(),
            'environment' => env('APP_ENV'),
            'trace' => $this->trace
        ];


        $client = new Client();
        $client->post(ServerConfig::ExceptionUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LARA_MONITOR_APP_TOKEN')
            ],
            RequestOptions::JSON => $data
        ]);

    }
}
