<?php

namespace Test\Unit\Component\Routing;

use Lencse\Rectum\Component\Routing\RoutingResult;
use PHPUnit\Framework\TestCase;

class RoutingResultTest extends TestCase
{

    public function testRoutingResult()
    {
        $result = new RoutingResult('Handler', ['a' => 'b']);
        $this->assertEquals('Handler', $result->getHandlerClass());
        $this->assertEquals(['a' => 'b'], $result->getParams());
    }
}
