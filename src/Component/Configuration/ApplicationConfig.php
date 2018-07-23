<?php

namespace Lencse\Rectum\Component\Configuration;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

interface ApplicationConfig
{

    public function dependencyInjectionConfig(): DependencyInjectionConfig;

    public function routingConfig(): RoutingConfig;
}
