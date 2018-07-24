<?php

namespace App;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

return new class implements ApplicationConfig
{

    public function dependencyInjectionConfig(): DependencyInjectionConfig
    {
        return require __DIR__ . '/../config/dic.php';
    }

    public function routingConfig(): RoutingConfig
    {
        return require __DIR__ . '/../config/routing.php';
    }
};
