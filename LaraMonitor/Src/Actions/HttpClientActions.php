<?php

namespace LaraMonitor\Src\Actions;

use Illuminate\Support\Facades\Auth;
use LaraMonitor\Src\HttpClientEntry;
use LaraMonitor\Src\Jobs\Notification\Discord\HttpClientConnetionFailedJob;
use LaraMonitor\Src\Jobs\Notification\Discord\HttpClientErrorJob;
use LaraMonitor\Src\Jobs\Server\HttpClient\SendingConnectionFailedJob;
use LaraMonitor\Src\Jobs\Server\HttpClient\SendingResponseReceivedJob;
use LaraMonitor\Src\Models\HttpClient;

class HttpClientActions
{


    public static function sendingRequest(string $url, string $method, array $payload, array $headers): void
    {
        HttpClientEntry::save(
            url: $url,
            method: $method,
            payload: $payload,
            headers: $headers
        );

    }


    public static function responseReceived(
        string $url,
        string $method,
        array $payload,
        array $headers,
        string $response_status,
         $response
    ): void {
        $http_client_entry = HttpClientEntry::get();

        if (config('laramonitor.notification.discord.enable') && $response_status != '200') {
            HttpClientErrorJob::dispatch(
                message: 'Failed request on ' . env('APP_NAME'),
                url: $url,
                method: $method,
                payload: $payload,
                headers: $headers,
                ambiente: env('APP_ENV'),
                date_time: date('Y-m-d H:i:s'),
                response: $response,
                response_status: $response_status
            );
        }
        SendingResponseReceivedJob::dispatch(
            url: $url,
            method: $method,
            payload: $payload,
            headers: $headers,
            enviroment: env('APP_ENV'),
            date_time: date('Y-m-d H:i:s'),
            response: $response,
            response_status: $response_status,

        );
    }


    public static function conectionFailed(string $url, string $method, array $payload, array $headers)
    {
        $http_client_entry = HttpClientEntry::get();
        if (config('laramonitor.notification.discord.enable')) {
            HttpClientConnetionFailedJob::dispatch(
                message: "Connection Failed in Http Client on " . env('APP_NAME'),
                url: $http_client_entry['url'],
                method: $http_client_entry['method'],
                payload: $http_client_entry['payload'],
                headers: $http_client_entry['headers'],
                ambiente: $http_client_entry['environment'],
                date_time: $http_client_entry['sending_at'],
            );
        }


        SendingConnectionFailedJob::dispatch(
            url: $url,
            method: $method,
            payload: $payload,
            headers: $headers,
            enviroment: env('APP_ENV'),
            date_time: date('Y-m-d H:i:s'),
            auth: Auth::user()->toArray(),
            origin_request: request()->all()
        );

        HttpClient::create([
            'url' => $http_client_entry['url'],
            'method' => $http_client_entry['method'],
            'payload' => json_encode($http_client_entry['payload']),
            'headers' => json_encode($http_client_entry['headers']),
            'origin' => $http_client_entry['origin'],
            'environment' => $http_client_entry['environment'],
            'sending_at' => $http_client_entry['sending_at'],
            'status_code' => '500',
            'connection_failed' => 1
        ]);

    }
}
