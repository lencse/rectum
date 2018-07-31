<?php

namespace Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    public function testEnv()
    {
        $this->assertEquals('test', env('TEST_ENV_VAR'));
    }
}
