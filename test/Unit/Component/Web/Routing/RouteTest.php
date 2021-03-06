<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\Routing\Component\Route;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
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
