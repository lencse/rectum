<?php

namespace Test\Unit\Adapter\DependencyInjection;

use Lencse\Rectum\DependencyInjection\Caller;
use Lencse\Rectum\DependencyInjection\Container;
use Lencse\Rectum\DependencyInjection\Factory\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\DependencyInjection\Factory\Configuration\DependencyInjectionSetup;
use Lencse\Rectum\DependencyInjection\Factory\ContainerFactory;
use PHPUnit\Framework\TestCase;
use Test\Unit\Adapter\DependencyInjection\Factory\ConstructorParameter;
use Test\Unit\Adapter\DependencyInjection\Factory\DummyInterface;
use Test\Unit\Adapter\DependencyInjection\Factory\FactoryWithoutParameter;
use Test\Unit\Adapter\DependencyInjection\Factory\NoConstructorParameter;
use Test\Unit\Adapter\DependencyInjection\Mock\MockContainer;

class ContainerFactoryTest extends TestCase
{

    public function testCreateContainer()
    {
        $factory = new ContainerFactory();
        /** @var MockContainer $dic */
        $dic = $factory->createContainer(
            new class implements DependencyInjectionSetup
            {

                public function createContainer(): Container
                {
                    return new MockContainer();
                }

                public function injectSelf(): array
                {
                    return [
                        Caller::class
                    ];
                }
            },
            new class implements DependencyInjectionConfig
            {
                public function bind(): array
                {
                    return [
                        DummyInterface::class => NoConstructorParameter::class
                    ];
                }

                public function factory(): array
                {
                    return [
                        ConstructorParameter::class => FactoryWithoutParameter::class
                    ];
                }

                public function setup(): array
                {
                    return [
                        ConstructorParameter::class => ['value' => 2]
                    ];
                }
            }
        );
        $this->assertTrue($dic instanceof MockContainer);
        $this->assertEquals($dic, $dic->shared[Caller::class]);
        $this->assertEquals(NoConstructorParameter::class, $dic->bound[DummyInterface::class]);
        $this->assertEquals(FactoryWithoutParameter::class, $dic->factories[ConstructorParameter::class]);
        $this->assertEquals(['value' => 2], $dic->setupParams[ConstructorParameter::class]);
    }
}
