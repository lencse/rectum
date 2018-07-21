<?php

namespace Test\Unit\Framework\DependencyInjection;

use Lencse\Rectum\Component\Classes\Invoking\Invoker;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Framework\Classes\Method\Parameter\ReflectionMethodParameterAnalyzer;
use Lencse\Rectum\Framework\DependencyInjection\AurynContainerFactory;
use Lencse\Rectum\Framework\DependencyInjection\AurynParameterTransformer;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Test\Unit\Framework\DependencyInjection\Objects\ConstructorParameterWithDependency;
use Test\Unit\Framework\DependencyInjection\Objects\DummyInterface;
use Test\Unit\Framework\DependencyInjection\Objects\FactoryWithoutParameter;
use Test\Unit\Framework\DependencyInjection\Objects\FactoryWithParameter;
use Test\Unit\Framework\DependencyInjection\Objects\ConstructorParameter;
use Test\Unit\Framework\DependencyInjection\Objects\NoConstructorParameter;
use Test\Unit\Framework\DependencyInjection\Objects\Service1;
use Test\Unit\Framework\DependencyInjection\Objects\WithDependency1;
use Test\Unit\Framework\DependencyInjection\Objects\Service2;
use Test\Unit\Framework\DependencyInjection\Objects\WithDependency2;
use Test\Unit\Framework\DependencyInjection\Objects\WithDependencyAndParam1;
use Test\Unit\Framework\DependencyInjection\Objects\WithDependencyAndParam2;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class AurynContainerFactoryTest extends TestCase
{

    public function testMake()
    {
        $dic = $this->getContainer(new TestConfig([]));
        $obj = $dic->get(self::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAbstract()
    {
        $dic = $this->getContainer(new TestConfig([
            'bind' => [TestCase::class => AurynContainerFactoryTest::class]
        ]));
        $obj = $dic->get(parent::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAndShare()
    {
        $dic = $this->getContainer(new TestConfig([
            'bind' => [TestCase::class => AurynContainerFactoryTest::class]
        ]));
        /** @var NoConstructorParameter $obj1 */
        $obj1 = $dic->get(NoConstructorParameter::class);
        /** @var NoConstructorParameter $obj2 */
        $obj2 = $dic->get(NoConstructorParameter::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory()
    {
        $dic = $this->getContainer(new TestConfig([
            'factory' => [ConstructorParameter::class => FactoryWithoutParameter::class]
        ]));
        /** @var ConstructorParameter $result */
        $result = $dic->get(ConstructorParameter::class);
        $this->assertEquals(1, $result->value);
    }

    public function testInvoke()
    {
        $dic = $this->getContainer(new TestConfig([]));
        /** @var Invoker $invoker */
        $invoker = $dic->get(Invoker::class);
        $result = $invoker->invoke(FactoryWithoutParameter::class);
        $this->assertTrue($result instanceof ConstructorParameter);
    }

    public function testInvokeWithParameters()
    {
        $dic = $this->getContainer(new TestConfig([]));
        /** @var Invoker $invoker */
        $invoker = $dic->get(Invoker::class);
        /** @var ConstructorParameter $result */
        $result = $invoker->invoke(FactoryWithParameter::class, ['value' => 2]);
        $this->assertEquals(2, $result->value);
    }

    public function testInvokeWithUnnamedParameters()
    {
        $dic = $this->getContainer(new TestConfig([]));
        /** @var Invoker $invoker */
        $invoker = $dic->get(Invoker::class);
        /** @var ConstructorParameter $result */
        $result = $invoker->invoke(FactoryWithParameter::class, [2]);
        $this->assertEquals(2, $result->value);
    }

    public function testSetup()
    {
        $dic = $this->getContainer(new TestConfig([
            'setup' => [ConstructorParameter::class => ['value' => 2]]
        ]));
        /** @var ConstructorParameter $result */
        $result = $dic->get(ConstructorParameter::class);
        $this->assertEquals(2, $result->value);
    }

    public function testSetupWithDependency()
    {
        $dic = $this->getContainer(new TestConfig([
            'bind' => [DummyInterface::class => NoConstructorParameter::class],
            'setup' => [ConstructorParameterWithDependency::class => ['value' => 2]]
        ]));
        /** @var ConstructorParameterWithDependency $result */
        $result = $dic->get(ConstructorParameterWithDependency::class);
        $this->assertEquals(2, $result->value);
    }

    public function testWire()
    {
        $dic = $this->getContainer(new TestConfig([
            'wire' => [
                WithDependency1::class => ['dependency' => Service1::class],
                WithDependency2::class => ['dependency' => Service2::class],
            ]
        ]));
        /** @var WithDependency1 $obj1 */
        $obj1 = $dic->get(WithDependency1::class);
        /** @var WithDependency2 $obj2 */
        $obj2 = $dic->get(WithDependency2::class);
        $this->assertTrue($obj1->dependency instanceof Service1);
        $this->assertTrue($obj2->dependency instanceof Service2);
    }

    public function testWireAndSetup()
    {
        $dic = $this->getContainer(new TestConfig([
            'setup' => [
                WithDependencyAndParam1::class => ['value' => 1],
                WithDependencyAndParam2::class => ['value' => 2],
            ],
            'wire' => [
                WithDependencyAndParam1::class => ['dependency' => Service1::class],
                WithDependencyAndParam2::class => ['dependency' => Service2::class],
            ]
        ]));
        /** @var WithDependencyAndParam1 $obj1 */
        $obj1 = $dic->get(WithDependencyAndParam1::class);
        /** @var WithDependencyAndParam2 $obj2 */
        $obj2 = $dic->get(WithDependencyAndParam2::class);
        $this->assertTrue($obj1->dependency instanceof Service1);
        $this->assertTrue($obj2->dependency instanceof Service2);
    }

    public function testWireOverridesDefaultBinding()
    {
        $dic = $this->getContainer(new TestConfig([
            'bind' => [
                DummyInterface::class => Service2::class
            ],
            'wire' => [
                WithDependency1::class => ['dependency' => Service1::class],
            ]
        ]));
        /** @var WithDependency1 $obj1 */
        $obj1 = $dic->get(WithDependency1::class);
        /** @var WithDependency2 $obj2 */
        $obj2 = $dic->get(WithDependency2::class);
        $this->assertTrue($obj1->dependency instanceof Service1);
        $this->assertTrue($obj2->dependency instanceof Service2);
    }

    public function testHas()
    {
        $dic = $this->getContainer(new TestConfig([
            'bind' => [
                DummyInterface::class => NoConstructorParameter::class
            ]
        ]));

        $this->assertTrue($dic->has(DummyInterface::class));
        $this->assertTrue($dic->has(Service1::class));
        $this->assertFalse($dic->has('InvalidClass'));
    }

    private function getContainer(DependencyInjectionConfig $config): ContainerInterface
    {
        $factory = new AurynContainerFactory(
            new AurynParameterTransformer(),
            new ReflectionMethodParameterAnalyzer()
        );
        return $factory->createContainer($config);
    }
}
