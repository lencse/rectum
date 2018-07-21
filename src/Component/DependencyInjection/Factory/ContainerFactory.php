<?php

namespace Lencse\Rectum\Component\DependencyInjection\Factory;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Psr\Container\ContainerInterface;

interface ContainerFactory
{

    public function createContainer(DependencyInjectionConfig $config): ContainerInterface;
}
