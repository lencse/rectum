<?php

namespace Test\Unit\Framework\Routing;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Routing\Exception\BadMethodException;
use Lencse\Rectum\Component\Routing\Exception\NotFoundException;
use Lencse\Rectum\Component\Routing\Route;
use Lencse\Rectum\Component\Routing\RouteCollection;
use Lencse\Rectum\Framework\Routing\FastrouteRouter;
use PHPUnit\Framework\TestCase;

class FastrouteRouterTest extends TestCase
{

    public function testRoute()
    {
        $router = new FastrouteRouter(new RouteCollection([new Route(HttpMethod::get(), '/test', 'TestHandler')]));
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test'
        );
        $response = $router->route($request);
        $this->assertEquals('TestHandler', $response->getHandlerClass());
    }

    public function testParams()
    {
        $router = new FastrouteRouter(new RouteCollection([new Route(HttpMethod::get(), '/test/{id}', 'TestHandler')]));
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
            new Route(HttpMethod::post(), '/test/{id}', 'TestHandler')
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
