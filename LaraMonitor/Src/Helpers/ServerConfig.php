<?php

namespace LaraMonitor\Src\Helpers;

class ServerConfig
{
    static $base_url = 'localhost:9090';


    public static function HttpClientUrl()
    {
        return static::$base_url . '/api/app/httpclient';
    }

    public static function ExceptionUrl()
    {
        return static::$base_url . '/api/app/exception';
    }

    public static function JobsUrl()
    {
        return static::$base_url . '/api/app/job';
    }
    public static function JobsFailedUrl()
    {
        return static::$base_url . '/api/app/job/failed';
    }
    public static function JobsProcessedUrl()
    {
        return static::$base_url . '/api/app/job/processed';
    }
}
