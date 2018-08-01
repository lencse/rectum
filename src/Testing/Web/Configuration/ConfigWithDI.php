<?php

namespace Lencse\Rectum\Testing\Web\Configuration;

use Lencse\Rectum\Application\Configuration\ApplicationConfig;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;

class ConfigWithDI implements ApplicationConfig
{
    /**
     * @var DependencyInjectionConfig
     */
    private $dependencyInjectionConfig;

    public function __construct(DependencyInjectionConfig $dependencyInjectionConfig)
    {
        $this->dependencyInjectionConfig = $dependencyInjectionConfig;
    }

    public function dependencyInjectionConfig(): DependencyInjectionConfig
    {
        return $this->dependencyInjectionConfig;
    }

    public function routingConfig(): RoutingConfig
    {
        return new class() implements RoutingConfig {
            public function routes(): array
            {
                return [];
            }
        };
    }
}
