<?php

namespace Lencse\Rectum\DependencyInjection\Component\Factory;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Psr\Container\ContainerInterface;

interface ContainerFactory
{
    public function createContainer(DependencyInjectionConfig $config): ContainerInterface;
}
