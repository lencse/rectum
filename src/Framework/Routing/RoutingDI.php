<?php

namespace Lencse\Rectum\Framework\Routing;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Routing\RouteCollection;
use Lencse\Rectum\Component\Routing\Router;

class RoutingDI implements DependencyInjectionConfig
{

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
            RouteCollection::class => ['routes' => []],
        ];
    }

    public function wire(): array
    {
        return [];
    }
}
