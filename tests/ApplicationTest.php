<?php

namespace ElfSundae\Console\Test;

use ElfSundae\Console\Application;
use ElfSundae\Console\ClosureCommand;

class ApplicationTest extends TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(Application::class, new Application);
    }

    public function testConstruct()
    {
        $app = new Application('foobar', 'xyz');
        $this->assertSame('foobar', $app->getName());
        $this->assertSame('xyz', $app->getVersion());
    }

    public function testRegisterClosureCommand()
    {
        $app = new Application;
        $command = $app->command('foobar', function () {
        }, 'desc');
        $this->assertInstanceOf(ClosureCommand::class, $command);
        $this->assertSame('foobar', $command->getName());
        $this->assertSame('desc', $command->getDescription());
    }
}
