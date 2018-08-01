<?php

namespace App;

use Lencse\Rectum\Application\Configuration\ApplicationConfig;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;

return new class() implements ApplicationConfig {
    public function dependencyInjectionConfig(): DependencyInjectionConfig
    {
        return require __DIR__ . '/../config/dic.php';
    }

    public function routingConfig(): RoutingConfig
    {
        return require __DIR__ . '/../config/routing.php';
    }
};
