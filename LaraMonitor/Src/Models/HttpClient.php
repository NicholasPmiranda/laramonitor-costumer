<?php

namespace LaraMonitor\Src\Models;

use Illuminate\Database\Eloquent\Model;

class HttpClient extends Model
{
    protected $table = 'laramonitor_http_client_entries';

    protected $fillable = [
        'url',
        'method',
        'environment',
        'sending_at',
        'response',
        'payload',
        'headers',
        'origin',
        'processed',
        'connection_failed',
        'status_code'
    ];



}
