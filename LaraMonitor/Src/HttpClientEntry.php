<?php

namespace LaraMonitor\Src;

class HttpClientEntry
{
    public static string $url;
    public static string $method;
    public static array $payload;
    public static array $headers;
    public static string $origin;
    public static string $environment;
    public static  string $sending_at;


    public static function save(string $url, string $method, array $payload, array $headers)
    {
        static::$url = $url;
        static::$method= $method;
        static::$payload= $payload;
        static::$headers= $headers;
        static::$origin= env('APP_NAME');
        static::$environment= env('APP_ENV');
        static::$sending_at= date('Y-m-d H:i:s');


    }

    public static function get()
    {
        return [
            'url' => static::$url,
            'method' => static::$method,
            'payload' => static::$payload,
            'headers' => static::$headers,
            'origin' => static::$origin,
            'environment' => static::$environment,
            'sending_at' => static::$sending_at,
        ];
    }
}
