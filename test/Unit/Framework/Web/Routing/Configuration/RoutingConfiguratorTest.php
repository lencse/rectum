<?php

namespace Test\Unit\Framework\Web\Routing\Configuration;

use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Web\Routing\Route;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfigurator;
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
