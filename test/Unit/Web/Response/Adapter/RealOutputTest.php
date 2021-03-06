<?php

namespace Test\Unit\Web\Response\Adapter;

use Lencse\Rectum\Web\Response\Adapter\RealOutput;
use PHPUnit\Framework\TestCase;

class RealOutputTest extends TestCase
{
    public function testPrint()
    {
        $output = new RealOutput();
        ob_start();
        $output->print('Test');
        $result = ob_get_clean();
        $this->assertEquals('Test', $result);
    }
}
