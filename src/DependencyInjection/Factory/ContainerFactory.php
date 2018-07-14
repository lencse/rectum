<?php

namespace Lencse\Rectum\DependencyInjection\Factory;

use Lencse\Rectum\DependencyInjection\Container;
use Lencse\Rectum\DependencyInjection\Factory\Configuration\DependencyInjectionSetup;

class ContainerFactory
{

    public function createContainer(DependencyInjectionSetup $config): Container
    {
        return $config->createContainer();
    }
}
