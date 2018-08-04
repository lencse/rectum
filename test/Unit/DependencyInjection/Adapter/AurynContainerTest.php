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
use Lencse\Rectum\DependencyInjection\Configuration\Configurator;
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
        $dic = new Configurator();
        $container = new AurynContainer($dic->config());
        $obj = $container->get(self::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAbstract()
    {
        $dic = new Configurator();
        $dic = new AurynContainer($dic->config()
            ->add(new BindConfig(TestCase::class, self::class))
        );

        $obj = $dic->get(parent::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAndShare()
    {
        $dic = new Configurator();
        $container = new AurynContainer($dic->config());

        /** @var NoConstructorParameter $obj1 */
        $obj1 = $container->get(NoConstructorParameter::class);
        /** @var NoConstructorParameter $obj2 */
        $obj2 = $container->get(NoConstructorParameter::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory()
    {
        $dic = new Configurator();
        $container = new AurynContainer($dic->config()
            ->add(new FactoryConfig(ConstructorParameter::class, FactoryWithoutParameter::class))
        );

        /** @var ConstructorParameter $result */
        $result = $container->get(ConstructorParameter::class);
        $this->assertEquals(1, $result->value);
    }

    public function testInvoke()
    {
        $dic = new Configurator();
        $container = new AurynContainer($dic->config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        $result = $invoker->invoke(FactoryWithoutParameter::class, new ActualParameterCollection());
        $this->assertTrue($result instanceof ConstructorParameter);
    }

    public function testInvokeIsOnTheSameObject()
    {
        $dic = new Configurator();
        $container = new AurynContainer($dic->config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        $result1 = $invoker->invoke(Counter::class, new ActualParameterCollection());
        $this->assertEquals(1, $result1);
        $result2 = $invoker->invoke(Counter::class, new ActualParameterCollection());
        $this->assertEquals(2, $result2);
    }

    public function testInvokeWithParameters()
    {
        $dic = new Configurator();
        $container = new AurynContainer($dic->config());

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
        $dic = new Configurator();
        $container = new AurynContainer($dic->config());

        /** @var Invoker2 $invoker */
        $invoker = $container->get(Invoker2::class);
        /** @var ConstructorParameter $result */
        $result = $invoker->invokeWithOneParameter(FactoryWithParameter::class, 2);
        $this->assertEquals(2, $result->value);
    }

//    public function testSetup()
//    {
//        $dic = new Configurator();
//        $container = new AurynContainer($dic->config()
//            ->add(
//                $dic->setup()
//                    ->param('value', 2)
//            )
//        );
//
////        $container = $this->getContainer(new TestConfig([
////            'setup' => [ConstructorParameter::class => ['value' => 2]]
////        ]));
//        /** @var ConstructorParameter $result */
//        $result = $container->get(ConstructorParameter::class);
//        $this->assertEquals(2, $result->value);
//    }

//    public function testSetupWithDependency()
//    {
//        $dic = $this->getContainer(new TestConfig([
//            'bind' => [DummyInterface::class => NoConstructorParameter::class],
//            'setup' => [ConstructorParameterWithDependency::class => ['value' => 2]]
//        ]));
//        /** @var ConstructorParameterWithDependency $result */
//        $result = $dic->get(ConstructorParameterWithDependency::class);
//        $this->assertEquals(2, $result->value);
//    }
//
//    public function testWire()
//    {
//        $dic = $this->getContainer(new TestConfig([
//            'wire' => [
//                WithDependency1::class => ['dependency' => Service1::class],
//                WithDependency2::class => ['dependency' => Service2::class],
//            ]
//        ]));
//        /** @var WithDependency1 $obj1 */
//        $obj1 = $dic->get(WithDependency1::class);
//        /** @var WithDependency2 $obj2 */
//        $obj2 = $dic->get(WithDependency2::class);
//        $this->assertTrue($obj1->dependency instanceof Service1);
//        $this->assertTrue($obj2->dependency instanceof Service2);
//    }
//
//    public function testWireAndSetup()
//    {
//        $dic = $this->getContainer(new TestConfig([
//            'setup' => [
//                WithDependencyAndParam1::class => ['value' => 1],
//                WithDependencyAndParam2::class => ['value' => 2],
//            ],
//            'wire' => [
//                WithDependencyAndParam1::class => ['dependency' => Service1::class],
//                WithDependencyAndParam2::class => ['dependency' => Service2::class],
//            ]
//        ]));
//        /** @var WithDependencyAndParam1 $obj1 */
//        $obj1 = $dic->get(WithDependencyAndParam1::class);
//        /** @var WithDependencyAndParam2 $obj2 */
//        $obj2 = $dic->get(WithDependencyAndParam2::class);
//        $this->assertTrue($obj1->dependency instanceof Service1);
//        $this->assertTrue($obj2->dependency instanceof Service2);
//    }
//
//    public function testWireOverridesDefaultBinding()
//    {
//        $dic = $this->getContainer(new TestConfig([
//            'bind' => [
//                DummyInterface::class => Service2::class
//            ],
//            'wire' => [
//                WithDependency1::class => ['dependency' => Service1::class],
//            ]
//        ]));
//        /** @var WithDependency1 $obj1 */
//        $obj1 = $dic->get(WithDependency1::class);
//        /** @var WithDependency2 $obj2 */
//        $obj2 = $dic->get(WithDependency2::class);
//        $this->assertTrue($obj1->dependency instanceof Service1);
//        $this->assertTrue($obj2->dependency instanceof Service2);
//    }
//
//    public function testHas()
//    {
//        $dic = $this->getContainer(new TestConfig([
//            'bind' => [
//                DummyInterface::class => NoConstructorParameter::class
//            ]
//        ]));
//
//        $this->assertTrue($dic->has(DummyInterface::class));
//        $this->assertTrue($dic->has(Service1::class));
//        $this->assertFalse($dic->has('InvalidClass'));
//    }
//
//    public function testInstance()
//    {
//        $dic = $this->getContainer(new TestConfig([
//            'instance' => [
//                DummyInterface::class => new ConstructorParameter(1)
//            ]
//        ]));
//
//        /** @var ConstructorParameter $obj */
//        $obj = $dic->get(DummyInterface::class);
//        $this->assertEquals(1, $obj->value);
//    }
//
//    private function getContainer(DependencyInjectionConfig $config): ContainerInterface
//    {
//        $factory = new AurynContainerFactory(
//            new AurynParameterTransformer(),
//            new ReflectionMethodParameterAnalyzer()
//        );
//
//        return $factory->createContainer($config);
//    }
}
