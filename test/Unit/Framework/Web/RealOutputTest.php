<?php

namespace Test\Unit\Framework\Web;

use Lencse\Rectum\Framework\Response\RealOutput;
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
