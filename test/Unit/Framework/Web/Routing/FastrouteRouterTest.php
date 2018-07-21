<?php

namespace Test\Unit\Framework\Web\Routing;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Web\Routing\Exception\BadMethodException;
use Lencse\Rectum\Component\Web\Routing\Exception\NotFoundException;
use Lencse\Rectum\Component\Web\Routing\Route;
use Lencse\Rectum\Component\Web\Routing\RouteCollection;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
use Lencse\Rectum\Component\Web\Routing\SimpleRouteHandlingConfig;
use Lencse\Rectum\Framework\Web\Routing\FastrouteRouter;
use PHPUnit\Framework\TestCase;

class FastrouteRouterTest extends TestCase
{

    public function testRoute()
    {
        $router = new FastrouteRouter(new RouteCollection([
            new Route(HttpMethod::get(), '/test', new RouteHandlerPipeline(['TestHandler']))
        ]));
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test'
        );
        $response = $router->route($request);
        $this->assertEquals('TestHandler', $response->getHandlerPipeline()->current());
    }

    public function testParams()
    {
        $router = new FastrouteRouter(new RouteCollection([
            new Route(HttpMethod::get(), '/test/{id}', new RouteHandlerPipeline(['TestHandler']))
        ]));
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test/1'
        );
        $response = $router->route($request);
        $this->assertEquals(['id' => 1], $response->getParams());
    }

    public function testNotFound()
    {
        $router = new FastrouteRouter(new RouteCollection([]));
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test/1'
        );

        try {
            $router->route($request);
        } catch (NotFoundException $e) {
            $this->assertEquals($request, $e->getRequest());
            $this->assertEquals('Not found: /test/1', $e->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    public function testBadMethod()
    {
        $router = new FastrouteRouter(new RouteCollection([
            new Route(HttpMethod::post(), '/test/{id}', new RouteHandlerPipeline(['TestHandler']))
        ]));
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test/1'
        );
        try {
            $router->route($request);
        } catch (BadMethodException $e) {
            $this->assertEquals($request, $e->getRequest());
            $this->assertEquals('Method not allowed: GET on "/test/1"', $e->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }
}
