<?php

namespace Test\Unit\DependencyInjection\Adapter;

use Lencse\Rectum\Classes\Adapter\Method\Parameter\ReflectionMethodParameterAnalyzer;
use Lencse\Rectum\Classes\Component\Invoking\Invoker2;
use Lencse\Rectum\Classes\Component\Method\Parameter\ActualParameter;
use Lencse\Rectum\Classes\Component\Method\Parameter\ActualParameterCollection;
use Lencse\Rectum\DependencyInjection\Adapter\AurynContainer;
use Lencse\Rectum\DependencyInjection\Adapter\AurynContainerFactory;
use Lencse\Rectum\DependencyInjection\Adapter\AurynParameterTransformer;
use Lencse\Rectum\DependencyInjection\Configuration\BindConfig;
use Lencse\Rectum\DependencyInjection\Configuration\ConfigCollection;
use Lencse\Rectum\DependencyInjection\Configuration\Configurator as DIC;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\DependencyInjection\Configuration\FactoryConfig;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Test\Unit\DependencyInjection\Adapter\Objects\ConstructorParameter;
use Test\Unit\DependencyInjection\Adapter\Objects\ConstructorParameterWithDependency;
use Test\Unit\DependencyInjection\Adapter\Objects\Counter;
use Test\Unit\DependencyInjection\Adapter\Objects\DummyInterface;
use Test\Unit\DependencyInjection\Adapter\Objects\FactoryWithoutParameter;
use Test\Unit\DependencyInjection\Adapter\Objects\FactoryWithParameter;
use Test\Unit\DependencyInjection\Adapter\Objects\NoConstructorParameter;
use Test\Unit\DependencyInjection\Adapter\Objects\Service1;
use Test\Unit\DependencyInjection\Adapter\Objects\Service2;
use Test\Unit\DependencyInjection\Adapter\Objects\WithDependency1;
use Test\Unit\DependencyInjection\Adapter\Objects\WithDependency2;
use Test\Unit\DependencyInjection\Adapter\Objects\WithDependencyAndParam1;
use Test\Unit\DependencyInjection\Adapter\Objects\WithDependencyAndParam2;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class AurynContainerTest extends TestCase
{
    public function testMake()
    {
        $container = new AurynContainer(DIC::config());
        $obj = $container->get(self::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAbstract()
    {
        $config = DIC::config()
            ->add(new BindConfig(TestCase::class, self::class));
        $container = new AurynContainer($config);

        $obj = $container->get(parent::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAndShare()
    {
        $container = new AurynContainer(DIC::config());

        /** @var NoConstructorParameter $obj1 */
        $obj1 = $container->get(NoConstructorParameter::class);
        /** @var NoConstructorParameter $obj2 */
        $obj2 = $container->get(NoConstructorParameter::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory()
    {
        $config = DIC::config()
            ->add(new FactoryConfig(ConstructorParameter::class, FactoryWithoutParameter::class));
        $container = new AurynContainer($config);

        /** @var ConstructorParameter $result */
        $result = $container->get(ConstructorParameter::class);
        $this->assertEquals(1, $result->value);
    }

    public function testInvoke()
    {
        $container = new AurynContainer(DIC::config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        $result = $invoker->invoke(FactoryWithoutParameter::class, new ActualParameterCollection());
        $this->assertTrue($result instanceof ConstructorParameter);
    }

    public function testInvokeIsOnTheSameObject()
    {
        $container = new AurynContainer(DIC::config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        $result1 = $invoker->invoke(Counter::class, new ActualParameterCollection());
        $this->assertEquals(1, $result1);
        $result2 = $invoker->invoke(Counter::class, new ActualParameterCollection());
        $this->assertEquals(2, $result2);
    }

    public function testInvokeWithParameters()
    {
        $container = new AurynContainer(DIC::config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        /** @var ConstructorParameter $result */
        $result = $invoker->invoke(
            FactoryWithParameter::class,
            (new ActualParameterCollection())
                ->add(new ActualParameter('value', 2))
        );
        $this->assertEquals(2, $result->value);
    }

    public function testInvokeWithUnnamedParameter()
    {
        $container = new AurynContainer(DIC::config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        /** @var ConstructorParameter $result */
        $result = $invoker->invokeWithOneParameter(FactoryWithParameter::class, 2);
        $this->assertEquals(2, $result->value);
    }

    public function testSetup()
    {
        $config = DIC::config()
            ->add(DIC::setup(ConstructorParameter::class)->param('value', 2));
        $container = new AurynContainer($config);

        /** @var ConstructorParameter $result */
        $result = $container->get(ConstructorParameter::class);
        $this->assertEquals(2, $result->value);
    }

    public function testSetupWithDependency()
    {
        $config = DIC::config()
            ->add(DIC::bind(DummyInterface::class, NoConstructorParameter::class))
            ->add(DIC::setup(ConstructorParameterWithDependency::class)->param('value', 2));
        $container = new AurynContainer($config);

        /** @var ConstructorParameterWithDependency $result */
        $result = $container->get(ConstructorParameterWithDependency::class);
        $this->assertEquals(2, $result->value);
    }

    public function testWire()
    {
        $config = DIC::config()
            ->add(DIC::setup(WithDependency1::class)->wire('dependency', Service1::class))
            ->add(DIC::setup(WithDependency2::class)->wire('dependency', Service2::class));
        $container = new AurynContainer($config);

        /** @var WithDependency1 $obj1 */
        $obj1 = $container->get(WithDependency1::class);
        /** @var WithDependency2 $obj2 */
        $obj2 = $container->get(WithDependency2::class);
        $this->assertTrue($obj1->dependency instanceof Service1);
        $this->assertTrue($obj2->dependency instanceof Service2);
    }

    public function testWireAndSetup()
    {
        $config = DIC::config()
            ->add(DIC::setup(WithDependencyAndParam1::class)
                ->param('value', 1)
                ->wire('dependency', Service1::class))
            ->add(DIC::setup(WithDependencyAndParam2::class)
                ->param('value', 2)
                ->wire('dependency', Service2::class));
        $container = new AurynContainer($config);

        /** @var WithDependencyAndParam1 $obj1 */
        $obj1 = $container->get(WithDependencyAndParam1::class);
        /** @var WithDependencyAndParam2 $obj2 */
        $obj2 = $container->get(WithDependencyAndParam2::class);
        $this->assertTrue($obj1->dependency instanceof Service1);
        $this->assertTrue($obj2->dependency instanceof Service2);
    }

    public function testWireOverridesDefaultBinding()
    {
        $config = DIC::config()
            ->add(DIC::bind(DummyInterface::class, Service2::class))
            ->add(DIC::setup(WithDependency1::class)->wire('dependency', Service1::class));
        $container = new AurynContainer($config);

        /** @var WithDependency1 $obj1 */
        $obj1 = $container->get(WithDependency1::class);
        /** @var WithDependency2 $obj2 */
        $obj2 = $container->get(WithDependency2::class);
        $this->assertTrue($obj1->dependency instanceof Service1);
        $this->assertTrue($obj2->dependency instanceof Service2);
    }

    public function testHas()
    {
        $container = new AurynContainer(DIC::config());

        $this->assertTrue($container->has(DummyInterface::class));
        $this->assertTrue($container->has(Service1::class));
        $this->assertFalse($container->has('InvalidClass'));
    }

    public function testInstance()
    {
        $config = DIC::config()
            ->add(DIC::instance(DummyInterface::class, new ConstructorParameter(1)));
        $container = new AurynContainer($config);

        /** @var ConstructorParameter $obj */
        $obj = $container->get(DummyInterface::class);
        $this->assertEquals(1, $obj->value);
    }
}
