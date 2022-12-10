<?php

namespace LaraMonitor\Src\Jobs\Notification\Discord;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class HttpClientErrorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $message,
        protected string $url,
        protected string $method,
        protected array $payload,
        protected array $headers,
        protected string $ambiente,
        protected string $date_time,
        protected string|array $response,
        protected string $response_status,

    )
    {
    }

    public function handle()
    {
        $data = [
            'embeds' => [
                [
                    'title' => ":boom: $this->message" ,
                    'color' => '7506394',
                    'fields'=>[
                        [
                            'name'=> 'Url',
                            'value'=>$this->url,
                            'inline'=> true
                        ],
                        [
                            'name'=> 'Method',
                            'value'=> $this->method,
                            'inline'=> true
                        ],
                        [
                            'name'=> 'Response Status',
                            'value'=> $this->response_status,
                            'inline'=> true
                        ],
                        [
                            'name'=> 'Environment',
                            'value'=> $this->ambiente,
                            'inline'=> true
                        ],
                        [
                            'name'=> 'Date Time',
                            'value'=> $this->date_time,
                            'inline'=> true
                        ],
                        [
                            'name'=> 'Headers',
                            'value'=>$this->formatArray($this->headers),
                        ],
                        [
                            'name'=> 'Payload',
                            'value'=>$this->formatArray($this->payload),
                            'inline'=> true
                        ],
                        [
                            'name'=> 'Response',
                            'value'=>$this->formatArray($this->response),
                            'inline'=> true
                        ],
                    ]
                ]
            ]
        ];
        $client = new Client();
        $client->post(config('laramonitor.notification.discord.webhook_url'),[RequestOptions::JSON=> $data]);
    }


    public function formatArray(array|string $payload)
    {
        if(is_string($payload)){
            return  $payload;
        }

        $string = '';

        foreach ($payload as $index => $item) {
            if(!is_array($item)){
                $string.= $index.'='.$item. PHP_EOL;

            }else{
                $sub_string = '';
                foreach ($item as $sub_key => $sub_item){
                    $sub_string.= '->'.$sub_key.'='.$sub_item.PHP_EOL;
                }
                $string.= $index.':'.PHP_EOL;
                $string.= $sub_string;

            }


        }
        return $string;
    }
}
