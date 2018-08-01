<?php

namespace Test\Unit\Web\Routing\Adapter;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Web\Routing\Adapter\FastRoutePath;
use Lencse\Rectum\Web\Routing\Adapter\FastrouteRouter;
use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\Routing\Exception\BadMethodException;
use Lencse\Rectum\Web\Routing\Exception\NotFoundException;
use Lencse\Rectum\Web\Routing\Component\Route;
use Lencse\Rectum\Web\Routing\Component\RouteCollection;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use Lencse\Rectum\Web\Routing\Component\Router;
use PHPUnit\Framework\TestCase;

class FastrouteRouterTest extends TestCase
{
    public function testRoute()
    {
        $router = $this->createRouter([
            new Route(HttpMethod::get(), '/test', new RouteHandlerPipeline(['TestHandler']))
        ]);
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test'
        );
        $response = $router->route($request);
        $this->assertEquals('TestHandler', $response->getHandlerPipeline()->current());
    }

    public function testParams()
    {
        $router = $this->createRouter([
            new Route(HttpMethod::get(), '/test/{id}', new RouteHandlerPipeline(['TestHandler']))
        ]);
        $request = new ServerRequest(
            HttpMethod::get(),
            '/test/1'
        );
        $response = $router->route($request);
        $this->assertEquals(['id' => 1], $response->getParams());
    }

    public function testNotFound()
    {
        $router = $this->createRouter([]);
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
        $router = $this->createRouter([
            new Route(HttpMethod::post(), '/test/{id}', new RouteHandlerPipeline(['TestHandler']))
        ]);
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

    public function testBadParameterFormat()
    {
        $router = $this->createRouter([
            new Route(
                HttpMethod::get(),
                '/test/{id}',
                new RouteHandlerPipeline(['Handler']),
                ['id' => '\d{3}']
            )
        ]);
        $request = new ServerRequest(
            'GET',
            '/test/1'
        );
        $this->expectException(NotFoundException::class);
        $router->route($request);
    }

    public function testGoodParameterFormat()
    {
        $router = $this->createRouter([
            new Route(
                HttpMethod::get(),
                '/test/{id}',
                new RouteHandlerPipeline(['Handler']),
                ['id' => '\d{3}']
            )
        ]);
        $request = new ServerRequest(
            'GET',
            '/test/123'
        );
        $result = $router->route($request);
        $this->assertEquals('123', $result->getParams()['id']);
    }

    /**
     * @param Route[] $routes
     *
     * @return Router
     */
    private function createRouter(array $routes): Router
    {
        return new FastrouteRouter(new RouteCollection($routes), new FastRoutePath());
    }
}
