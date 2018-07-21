<?php

namespace Test\Unit\Framework\Web\Response;

use Lencse\Rectum\Framework\Web\Response\RealOutput;
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
