<?php

namespace Lencse\Rectum\Framework\Web\Routing;

use Lencse\Rectum\Web\Routing\Adapter\FastrouteRouter;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Routing\Component\RouteCollection;
use Lencse\Rectum\Web\Routing\Component\Router;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfigurator;

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
        return [
            RouteCollection::class => RoutingConfigurator::class,
        ];
    }

    public function setup(): array
    {
        return [
            RoutingConfigurator::class => ['config' => $this->config],
        ];
    }

    public function wire(): array
    {
        return [];
    }

    public function instance(): array
    {
        return [];
    }
}
