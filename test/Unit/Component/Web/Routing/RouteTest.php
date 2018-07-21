<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Web\Routing\Route;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{

    public function testRoute()
    {
        $route = new Route(HttpMethod::get(), '/path', new RouteHandlerPipeline(['Handler']));
        $this->assertEquals(HttpMethod::get(), $route->getMethod());
        $this->assertEquals('/path', $route->getPath());
        $this->assertEquals('Handler', $route->getHandlerPipeline()->first());
    }
}
