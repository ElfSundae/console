<?php

namespace ElfSundae\Console;

use Illuminate\Container\Container;
use Illuminate\Console\Application as ConsoleApplication;
use Illuminate\Events\Dispatcher as EventsDispatcher;

class Application extends ConsoleApplication
{
    /**
     * Create a new console application.
     *
     * @param  string  $name
     * @param  string  $version
     */
    public function __construct($name = "Console Application", $version = '1.0.0')
    {
        parent::__construct($laravel = new Container, new EventsDispatcher($laravel), $version);

        $this->setName($name);
    }
}
