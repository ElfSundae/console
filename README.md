[![Latest Version on Packagist](https://img.shields.io/packagist/v/elfsundae/console.svg?style=flat-square)](https://packagist.org/packages/elfsundae/console)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ElfSundae/console/master.svg?style=flat-square)](https://travis-ci.org/ElfSundae/console)
[![StyleCI](https://styleci.io/repos/100198819/shield)](https://styleci.io/repos/100198819)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/4658ebb9-710d-40fb-9573-1d8ada1991b4.svg?style=flat-square)](https://insight.sensiolabs.com/projects/4658ebb9-710d-40fb-9573-1d8ada1991b4)
[![Quality Score](https://img.shields.io/scrutinizer/g/ElfSundae/console.svg?style=flat-square)](https://scrutinizer-ci.com/g/ElfSundae/console)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/ElfSundae/console/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/ElfSundae/console/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/elfsundae/console.svg?style=flat-square)](https://packagist.org/packages/elfsundae/console)

CLI library based on [Laravel Console][Laravel Artisan] for creating PHP console application.

## Installation

```sh
$ composer require elfsundae/console
```

## Usage

First, create a PHP script and make it executable:

```php
#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

$app = new ElfSundae\Console\Application;

// ... register commands

$app->run();
```

Then, you can register commands using `add` or `command` method.

The `add` method accepts an `Illuminate\Console\Command` instance or a `Symfony\Component\Console\Command\Command` instance. The `command` method may be used for register a Closure based command, it accepts three arguments: the command signature, a Closure which receives the commands arguments and options, and the optional description of the command.

```php
class Example extends Illuminate\Console\Command
{
    protected $signature = 'example
        {--foo=bar : The "foo" option description}';

    protected $description = 'Example command description';

    public function handle()
    {
        $this->comment($this->option('foo'));
    }
}

$app->add(new Example);

$app->command('title {username}', function ($username) {
    $this->comment(title_case($username));
}, 'The `title` command description');
```

To build a single command application, you may pass `true` to the second argument of the `setDefaultCommand` method, or just call the `runAsSingle` method:

```php
(new ElfSundae\Console\Application)
    ->add($command = new Example)
    ->getApplication()
    ->setDefaultCommand($command->getName(), true)
    ->run();
```

```php
(new ElfSundae\Console\Application)
    ->add(new Example)
    ->getApplication()
    ->runAsSingle();
```

## Documentation

- [Laravel Artisan][]
- [Symfony Console Component][]

## Testing

```sh
$ composer test
```

## License

This package is open-sourced software licensed under the [MIT License](LICENSE.md).

[Laravel Artisan]: https://laravel.com/docs/artisan
[Symfony Console Component]: http://symfony.com/doc/current/components/console.html
