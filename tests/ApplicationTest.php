<?php

namespace ElfSundae\Console\Test;

use ElfSundae\Console\Application;

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
}
