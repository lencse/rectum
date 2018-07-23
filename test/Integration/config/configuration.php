<?php

namespace AppConfig;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

return new class implements ApplicationConfig
{

    public function routingConfig(): RoutingConfig
    {
        return require 'routing.php';
    }
};
