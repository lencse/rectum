<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use Lencse\Rectum\Web\Routing\Component\RoutingResult;
use PHPUnit\Framework\TestCase;

class RoutingResultTest extends TestCase
{
    public function testRoutingResult()
    {
        $result = new RoutingResult(
            new RouteHandlerPipeline(['Handler']),
            ['a' => 'b']
        );
        $this->assertEquals('Handler', $result->getHandlerPipeline()->first());
        $this->assertEquals(['a' => 'b'], $result->getParams());
    }
}
