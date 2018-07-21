<?php

namespace Test\Unit\Component\Routing;

use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{

    public function testRoute()
    {
        $route = new Route(HttpMethod::get(), '/path', 'Handler');
        $this->assertEquals(HttpMethod::get(), $route->getMethod());
        $this->assertEquals('/path', $route->getPath());
        $this->assertEquals('Handler', $route->getHandlerClass());
    }
}
