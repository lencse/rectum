<?php

namespace Lencse\Rectum\Application\Configuration;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;

interface ApplicationConfig
{
    public function dependencyInjectionConfig(): DependencyInjectionConfig;

    public function routingConfig(): RoutingConfig;
}
