<?php

namespace Test\Unit\Adapter\DependencyInjection;

use Lencse\Rectum\Adapter\DependencyInjection\AurynContainer;
use Lencse\Rectum\DependencyInjection\Container;
use Lencse\Rectum\DependencyInjection\Factory\Configuration\DependencyInjectionSetup;
use Lencse\Rectum\DependencyInjection\Factory\ContainerFactory;
use PHPUnit\Framework\TestCase;

class ContainerFactoryTest extends TestCase
{

    public function testCreateContainer()
    {
        $factory = new ContainerFactory();
        $dic = $factory->createContainer(new class implements DependencyInjectionSetup {

            public function createContainer(): Container
            {
                return new AurynContainer();
            }

        });
        $this->assertTrue($dic instanceof AurynContainer);
    }
}
