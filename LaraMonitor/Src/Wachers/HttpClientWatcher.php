<?php

namespace LaraMonitor\Src\Wachers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;
use LaraMonitor\Src\Actions\HttpClientActions;

class HttpClientWatcher extends Watcher
{
    public function register(Application $app)
    {
        $app['events']->listen(RequestSending::class, [$this, 'sendingRequest']);
        $app['events']->listen(ResponseReceived::class, [$this, 'responseReceived']);
        $app['events']->listen(ConnectionFailed::class, [$this, 'ConnectionFailed']);
    }


    public function sendingRequest(RequestSending $event): void
    {
        HttpClientActions::sendingRequest(
            url: $event->request->url(),
            method: $event->request->method(),
            payload: $event->request->data(),
            headers: $event->request->headers()
        );
    }

    public function responseReceived(responseReceived $event): void
    {
        HttpClientActions::responseReceived(
            url: $event->request->url(),
            method: $event->request->method(),
            payload: $event->request->data(),
            headers: $event->request->headers(),
            response_status: $event->response->status(),
            response: json_decode($event->response->body(), true),
        );
    }


    public function ConnectionFailed(ConnectionFailed $event): void
    {
        HttpClientActions::conectionFailed(
            url: $event->request->url(),
            method: $event->request->method(),
            payload: $event->request->data(),
            headers: $event->request->headers()
        );
    }
}
