<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Component\Web\Routing\RoutingResult;
use Lencse\Rectum\Component\Web\Routing\SimpleRouteHandlingConfig;
use PHPUnit\Framework\TestCase;

class RoutingResultTest extends TestCase
{

    public function testRoutingResult()
    {
        $result = new RoutingResult(new SimpleRouteHandlingConfig('Handler'), ['a' => 'b']);
        $this->assertEquals('Handler', $result->getHandlingConfig()->getRequestProcessorClass());
        $this->assertEquals(['a' => 'b'], $result->getParams());
    }
}
