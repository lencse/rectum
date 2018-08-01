<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\Routing\Component\Route;
use Lencse\Rectum\Web\Routing\Component\RouteCollection;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use PHPUnit\Framework\TestCase;

class RouteCollectionTest extends TestCase
{
    public function testRouteCollection()
    {
        $arr = [
            new Route(HttpMethod::get(), '/path', new RouteHandlerPipeline(['GetHandler'])),
            new Route(HttpMethod::post(), '/path', new RouteHandlerPipeline(['GetHandler'])),
        ];
        $routes = new RouteCollection($arr);
        foreach ($routes as $k => $v) {
            $this->assertEquals($arr[$k], $v);
        }
    }
}
