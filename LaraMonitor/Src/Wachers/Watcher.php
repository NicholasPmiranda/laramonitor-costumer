<?php

namespace LaraMonitor\Src\Wachers;

use Illuminate\Foundation\Application;

abstract class Watcher
{
    public $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    abstract public function register(Application $app);
}
