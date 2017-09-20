<?php

namespace ElfSundae\Console;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Symfony\Component\Console\Output\OutputInterface;
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
        parent::__construct($laravel = new Container, new EventsDispatcher($laravel), $version);

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

    /**
     * Run the current application as a single command application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface|null  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $output
     * @return int
     */
    public function runAsSingle(InputInterface $input = null, OutputInterface $output = null)
    {
        if ($command = Arr::last($this->all())) {
            $this->setDefaultCommand($command->getName(), true);
        }

        return $this->run($input, $output);
    }
}
