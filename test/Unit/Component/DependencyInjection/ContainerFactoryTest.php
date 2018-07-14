<?php

namespace Test\Unit\Component\DependencyInjection;

use Lencse\Rectum\Component\DependencyInjection\Container;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionSetup;
use Lencse\Rectum\Component\DependencyInjection\Factory\ContainerFactory;
use PHPUnit\Framework\TestCase;
use Test\Unit\Component\DependencyInjection\Mock\MockContainer;

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
                        'InjectSelf'
                    ];
                }
            },
            new class implements DependencyInjectionConfig
            {
                public function bind(): array
                {
                    return [
                        'A' => 'a'
                    ];
                }

                public function factory(): array
                {
                    return [
                        'A' => 'Af'
                    ];
                }

                public function setup(): array
                {
                    return [
                        'A' => ['a' => 2]
                    ];
                }
            }
        );
        $this->assertTrue($dic instanceof MockContainer);
        $this->assertEquals($dic, $dic->shared['InjectSelf']);
        $this->assertEquals('a', $dic->bound['A']);
        $this->assertEquals('Af', $dic->factories['A']);
        $this->assertEquals(['a' => 2], $dic->setupParams['A']);
    }
}
