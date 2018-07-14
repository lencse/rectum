<?php

namespace Lencse\Rectum\DependencyInjection\Factory;

use Lencse\Rectum\DependencyInjection\Container;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionSetup;

class ContainerFactory
{

    /**
     * @psalm-suppress MixedArgument
     */
    public function createContainer(DependencyInjectionSetup $setup, DependencyInjectionConfig $config): Container
    {
        $dic = $setup->createContainer();
        foreach ($setup->injectSelf() as $class) {
            $dic->bindInstance($class, $dic);
        }
        foreach ($config->bind() as $abstract => $concrete) {
            $dic->bind($abstract, $concrete);
        }
        foreach ($config->factory() as $class => $factoryClass) {
            $dic->factory($class, $factoryClass);
        }
        foreach ($config->setup() as $class => $params) {
            $dic->setup($class, $params);
        }

        return $dic;
    }
}
