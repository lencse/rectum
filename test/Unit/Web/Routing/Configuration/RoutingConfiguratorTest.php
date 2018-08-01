<?php

namespace Test\Unit\Web\Routing\Configuration;

use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\Routing\Component\Route;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfigurator;
use PHPUnit\Framework\TestCase;

class RoutingConfiguratorTest extends TestCase
{
    public function testRoutes()
    {
        $configurator = new RoutingConfigurator(new class() implements RoutingConfig {
            public function routes(): array
            {
                return [
                    [HttpMethod::get(), '/', ['Handler']],
                    [HttpMethod::get(), '/', 'Handler'],
                    [HttpMethod::get(), '/', ['Handler1', 'Handler2'], ['id' => '\d+']],
                ];
            }
        });

        $routes = $configurator();

        $expected = [
            new Route(HttpMethod::get(), '/', new RouteHandlerPipeline(['Handler'])),
            new Route(HttpMethod::get(), '/', new RouteHandlerPipeline(['Handler'])),
            new Route(HttpMethod::get(), '/', new RouteHandlerPipeline(['Handler1', 'Handler2']), ['id' => '\d+']),
        ];

        foreach ($routes as $i => $route) {
            $this->assertEquals($expected[$i], $route);
        }
    }
}
