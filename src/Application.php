<?php

namespace ElfSundae\Console;

use Closure;
use Exception;
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
     * Register a new command.
     *
     * @param  mixed  $command
     * @return $this
     */
    public function register($command)
    {
        $num = func_num_args();

        if (is_string($command) && $num > 1 && func_get_arg(1) instanceof Closure) {
            $command = call_user_func_array([static::class, 'makeCommand'], func_get_args());
        }

        if ($command instanceof Command) {
            $this->add($command);
        } else {
            throw new Exception("Invalid parameters", 1);
        }

        if ($num > 1 && func_get_arg($num - 1) === true) {
            $this->setDefaultCommand($command->getName(), true);
        }

        return $this;
    }

    /**
     * Create a new Closure based command.
     *
     * @param  string  $signature
     * @param  \Closure  $callback
     * @param  string  $description
     * @return \ElfSundae\Console\ClosureCommand
     */
    public static function makeCommand($signature, Closure $callback, $description = null)
    {
        return (new ClosureCommand($signature, $callback))->describe($description);
    }

    /**
     * Create a new console application with a single command and run it.
     *
     * @param  string  $name
     * @param  string  $version
     * @param  mixed  ...$command
     * @return int
     */
    public static function execute($name, $version, ...$command)
    {
        $command[] = true;

        return (new static($name, $version))
            ->register(...$command)
            ->run();
    }
}
