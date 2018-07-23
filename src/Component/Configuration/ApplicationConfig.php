<?php

namespace Lencse\Rectum\Component\Configuration;

use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

interface ApplicationConfig
{

    public function routingConfig(): RoutingConfig;
}
