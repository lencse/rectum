<?php

namespace Test\Unit\Adapter\Web\Response;

use Lencse\Rectum\Adapter\Web\Response\RealOutput;
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
