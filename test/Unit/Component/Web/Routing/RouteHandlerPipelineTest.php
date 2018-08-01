<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Web\Routing\Exception\EmptyRouteHandlerPipelineException;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use PHPUnit\Framework\TestCase;

class RouteHandlerPipelineTest extends TestCase
{
    public function testRouteHandlerPipeline()
    {
        $arr = [
            'Handler1',
            'Handler2',
        ];
        $routes = new RouteHandlerPipeline($arr);
        foreach ($routes as $k => $v) {
            $this->assertEquals($arr[$k], $v);
        }
    }

    public function testValidationn()
    {
        $this->expectException(EmptyRouteHandlerPipelineException::class);
        new RouteHandlerPipeline([]);
    }
}
