<?php

namespace ElfSundae\Console;

use Closure;
use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Illuminate\Console\Application as LaravelApplication;

class Application extends LaravelApplication
{
    /**
     * Create a new console application.
     *
     * @param  string  $name
     * @param  string  $version
     */
    public function __construct($name = 'Console Application', $version = '1.0.0')
    {
        parent::__construct(
            $laravel = new Container,
            new EventsDispatcher($laravel),
            $version
        );

        $this->setName($name);
        $this->setAutoExit(true);
        $this->setCatchExceptions(true);
    }

    /**
     * Register a Closure based command.
     *
     * @param  string  $signature
     * @param  \Closure  $callback
     * @param  string  $description
     * @return \ElfSundae\Console\ClosureCommand
     */
    public function command($signature, Closure $callback, $description = null)
    {
        return $this->add(
            (new ClosureCommand($signature, $callback))->describe($description)
        );
    }
}
