<?php

namespace Test\Unit\Framework\DependencyInjection;

use Lencse\Rectum\Component\DependencyInjection\Invoker;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Container;
use Lencse\Rectum\Framework\DependencyInjection\AurynContainerContainerFactory;
use Lencse\Rectum\Framework\DependencyInjection\AurynParameterTransformer;
use PHPUnit\Framework\TestCase;
use Test\Unit\Framework\DependencyInjection\Objects\ConstructorParameterWithDependency;
use Test\Unit\Framework\DependencyInjection\Objects\DummyInterface;
use Test\Unit\Framework\DependencyInjection\Objects\FactoryWithoutParameter;
use Test\Unit\Framework\DependencyInjection\Objects\FactoryWithParameter;
use Test\Unit\Framework\DependencyInjection\Objects\ConstructorParameter;
use Test\Unit\Framework\DependencyInjection\Objects\NoConstructorParameter;

class AurynContainerFactoryTest extends TestCase
{

    public function testMake(): void
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [];
            }
        });
        $obj = $dic->make(self::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAbstract(): void
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [TestCase::class => AurynContainerFactoryTest::class];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [];
            }
        });
        $obj = $dic->make(parent::class);
        $this->assertTrue($obj instanceof self);
    }


    public function testMakeAndShare(): void
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [TestCase::class => AurynContainerFactoryTest::class];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [];
            }
        });
        /** @var NoConstructorParameter $obj1 */
        $obj1 = $dic->make(NoConstructorParameter::class);
        /** @var NoConstructorParameter $obj2 */
        $obj2 = $dic->make(NoConstructorParameter::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory(): void
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [];
            }

            public function factory(): array
            {
                return [ConstructorParameter::class => FactoryWithoutParameter::class];
            }

            public function setup(): array
            {
                return [];
            }
        });
        /** @var ConstructorParameter $result */
        $result = $dic->make(ConstructorParameter::class);
        $this->assertEquals(1, $result->value);
    }

    public function testCall()
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [];
            }
        });
        /** @var Invoker $invoker */
        $invoker = $dic->make(Invoker::class);
        $result = $invoker->call(FactoryWithoutParameter::class);
        $this->assertTrue($result instanceof ConstructorParameter);
    }

    public function testCallWithParameters()
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [];
            }
        });
        /** @var Invoker $invoker */
        $invoker = $dic->make(Invoker::class);
        /** @var ConstructorParameter $result */
        $result = $invoker->call(FactoryWithParameter::class, ['value' => 2]);
        $this->assertEquals(2, $result->value);
    }

    public function testSetup()
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [ConstructorParameter::class => ['value' => 2]];
            }
        });
        /** @var ConstructorParameter $result */
        $result = $dic->make(ConstructorParameter::class);
        $this->assertEquals(2, $result->value);
    }

    public function testSetupWithDependency()
    {
        $dic = $this->getContainer(new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [DummyInterface::class => NoConstructorParameter::class];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [ConstructorParameterWithDependency::class => ['value' => 2]];
            }
        });
        /** @var ConstructorParameterWithDependency $result */
        $result = $dic->make(ConstructorParameterWithDependency::class);
        $this->assertEquals(2, $result->value);
    }

    private function getContainer(DependencyInjectionConfig $config): Container
    {
        $factory = new AurynContainerContainerFactory(new AurynParameterTransformer());
        return  $factory->createContainer($config);
    }
}
