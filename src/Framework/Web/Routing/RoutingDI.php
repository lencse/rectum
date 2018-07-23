<?php

namespace Lencse\Rectum\Framework\Web\Routing;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Routing\RouteCollection;
use Lencse\Rectum\Component\Web\Routing\Router;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

class RoutingDI implements DependencyInjectionConfig
{

    /**
     * @var RoutingConfig
     */
    private $config;

    public function __construct(RoutingConfig $config)
    {
        $this->config = $config;
    }

    public function bind(): array
    {
        return [
            Router::class => FastrouteRouter::class,
        ];
    }

    public function factory(): array
    {
        return [];
    }

    public function setup(): array
    {
        return [
            RouteCollection::class => ['routes' => $this->config->routes()],
        ];
    }

    public function wire(): array
    {
        return [];
    }
}
