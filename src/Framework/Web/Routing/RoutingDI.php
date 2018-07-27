<?php

namespace Lencse\Rectum\Framework\Web\Routing;

use Lencse\Rectum\Adapter\Web\Routing\FastrouteRouter;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Routing\RouteCollection;
use Lencse\Rectum\Component\Web\Routing\Router;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfigurator;

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
