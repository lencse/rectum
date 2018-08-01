<?php

namespace Lencse\Rectum\Application\Configuration;

use Lencse\Rectum\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Routing\Configuration\CompositeRoutingConfig;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;

class CompositeApplicationConfig implements ApplicationConfig
{
    /**
     * @var ApplicationConfig[]
     */
    private $configs;

    /**
     * @param ApplicationConfig[] $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function dependencyInjectionConfig(): DependencyInjectionConfig
    {
        return new CompositeDependencyInjectionConfig(
            array_map(
                function (ApplicationConfig $config): DependencyInjectionConfig {
                    return $config->dependencyInjectionConfig();
                },
                $this->configs
            )
        );
    }

    public function routingConfig(): RoutingConfig
    {
        return new CompositeRoutingConfig(
            array_map(
                function (ApplicationConfig $config): RoutingConfig {
                    return $config->routingConfig();
                },
                $this->configs
            )
        );
    }
}
