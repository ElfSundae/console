<?php

namespace ElfSundae\Console;

use Closure;
use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Illuminate\Console\Application as LaravelConsoleApplication;

class Application extends LaravelConsoleApplication
{
    /**
     * Create a new console application.
     *
     * @param  string  $name
     * @param  string  $version
     */
    public function __construct($name = 'Console Application', $version = '1.0.0')
    {
        parent::__construct($laravel = new Container, new EventsDispatcher($laravel), $version);

        $this->setName($name);
        $this->setAutoExit(true);
        $this->setCatchExceptions(true);
    }

    /**
     * Add a command object.
     *
     * @param  \Symfony\Component\Console\Command\Command  $command
     * @return $this
     */
    public function add(Command $command)
    {
        parent::add($command);

        if (func_num_args() > 1 && (bool) func_get_arg(1) == true) {
            $this->setDefaultCommand($command->getName(), true);
        }

        return $this;
    }

    /**
     * Create a new Closure based command.
     *
     * @param  string  $signature
     * @param  \Closure  $callback
     * @return \ElfSundae\Console\ClosureCommand
     */
    public static function command($signature, Closure $callback)
    {
        return new ClosureCommand($signature, $callback);
    }

    /**
     * Create a new console application with a single command and run it.
     *
     * @param  string  $name
     * @param  string  $version
     * @param  \Symfony\Component\Console\Command\Command  $command
     * @return int
     */
    public static function runCommand($name, $version, Command $command)
    {
        return (new static($name, $version))
            ->add($command, true)
            ->run();
    }
}
