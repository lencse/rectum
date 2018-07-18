<?php

namespace Test\Unit\Component\Routing;

use Lencse\Rectum\Component\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{

    public function testRoute()
    {
        $route = new Route('/path', 'Handler');
        $this->assertEquals('/path', $route->getPath());
        $this->assertEquals('Handler', $route->getHandlerClass());
    }
}
