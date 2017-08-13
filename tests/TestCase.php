<?php

namespace ElfSundae\Console\Test;

use Mockery as m;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        m::close();
    }
}
