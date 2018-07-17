<?php

namespace Lencse\Rectum\Component\DependencyInjection\Factory;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Container;

interface ContainerFactory
{

    public function createContainer(DependencyInjectionConfig $config): Container;
}
