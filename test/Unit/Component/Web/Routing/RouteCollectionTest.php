<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Web\Routing\Route;
use Lencse\Rectum\Component\Web\Routing\RouteCollection;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
use Lencse\Rectum\Component\Web\Routing\SimpleRouteHandlingConfig;
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
