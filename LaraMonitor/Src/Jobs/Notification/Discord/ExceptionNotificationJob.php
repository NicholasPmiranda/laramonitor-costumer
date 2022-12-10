<?php

namespace LaraMonitor\Src\Jobs\Notification\Discord;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExceptionNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(
        protected string $level,
        protected string $message,
        protected string $file,
        protected int $line,
        protected array $request_payload,
        protected string $origin,
    ) {
    }

    public function handle()
    {
        $data = [
            'embeds' => [
                [
                    'title' => ":boom: $this->message" ?? '' ,
                    'color' => '7506394',
                    'fields'=>[
                        [
                            'name' => 'Level',
                            'value' => $this->level?? '',
                            'inline' => true
                        ],
                        [
                            'name' => 'File',
                            'value' => $this->file?? '',
                            'inline' => true
                        ],
                        [
                            'name' => 'Line',
                            'value' => $this->line ?? '',
                            'inline' => true
                        ],
                        [
                            'name' => 'Origin',
                            'value' => $this->origin ?? '',
                            'inline' => true
                        ],
                        [
                            'name' => 'Environment',
                            'value' => env('APP_ENV') ?? '',
                            'inline' => true
                        ],
                        [
                            'name' => 'Request Payload',
                            'value' => $this->formatArray($this->request_payload) ?? '',
                            'inline' => true
                        ],

                    ]
                ]
            ]
        ];
        $client = new Client();
        $client->post(config('laramonitor.notification.discord.webhook_url'), [RequestOptions::JSON => $data]);
    }


    public function formatArray(array|string $payload)
    {
        if(empty($payload)){
            return 'not send';
        }
        if (is_string($payload)) {
            return $payload;
        }

        $string = '';

        foreach ($payload as $index => $item) {
            if (!is_array($item)) {
                $string .= $index . '=' . $item . PHP_EOL;
            } else {
                $sub_string = '';
                foreach ($item as $sub_key => $sub_item) {
                    $sub_string .= '->' . $sub_key . '=' . $sub_item . PHP_EOL;
                }
                $string .= $index . ':' . PHP_EOL;
                $string .= $sub_string;
            }

        }
        return $string;
    }
}
