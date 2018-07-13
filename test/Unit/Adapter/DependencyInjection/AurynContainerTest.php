<?php

namespace Test\Unit\Adapter\DependencyInjection;

use Lencse\Rectum\Adapter\DependencyInjection\AurynContainer;
use PHPUnit\Framework\TestCase;
use Test\Unit\Adapter\DependencyInjection\Factory\ConstructorParameterWithDependency;
use Test\Unit\Adapter\DependencyInjection\Factory\DummyInterface;
use Test\Unit\Adapter\DependencyInjection\Factory\FactoryWithoutParameter;
use Test\Unit\Adapter\DependencyInjection\Factory\FactoryWithParameter;
use Test\Unit\Adapter\DependencyInjection\Factory\ConstructorParameter;
use Test\Unit\Adapter\DependencyInjection\Factory\NoConstructorParameter;

class AurynContainerTest extends TestCase
{

    public function testMake(): void
    {
        $dic = new AurynContainer();
        $obj = $dic->make(self::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAbstract(): void
    {
        $dic = new AurynContainer();
        $dic->bind(parent::class, self::class);
        $obj = $dic->make(parent::class);
        $this->assertTrue($obj instanceof self);
    }

    public function testMakeAndShare(): void
    {
        $dic = new AurynContainer();
        /** @var NoConstructorParameter $obj1 */
        $obj1 = $dic->make(NoConstructorParameter::class);
        /** @var NoConstructorParameter $obj2 */
        $obj2 = $dic->make(NoConstructorParameter::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory(): void
    {
        $dic = new AurynContainer();
        $dic->factory(ConstructorParameter::class, FactoryWithoutParameter::class);
        /** @var ConstructorParameter $result */
        $result = $dic->make(ConstructorParameter::class);
        $this->assertEquals(1, $result->value);
    }

    public function testCall()
    {
        $dic = new AurynContainer();
        $result = $dic->call(FactoryWithoutParameter::class);
        $this->assertTrue($result instanceof ConstructorParameter);
    }

    public function testCallWithParameters()
    {
        $dic = new AurynContainer();
        /** @var ConstructorParameter $result */
        $result = $dic->call(FactoryWithParameter::class, ['value' => 2]);
        $this->assertEquals(2, $result->value);
    }

    public function testSetup()
    {
        $dic = new AurynContainer();
        $dic->setup(ConstructorParameter::class, ['value' => 2]);
        /** @var ConstructorParameter $result */
        $result = $dic->make(ConstructorParameter::class);
        $this->assertEquals(2, $result->value);
    }

    public function testSetupWithDependency()
    {
        $dic = new AurynContainer();
        $dic->bind(DummyInterface::class, NoConstructorParameter::class);
        $dic->setup(ConstructorParameterWithDependency::class, ['value' => 2]);
        /** @var ConstructorParameterWithDependency $result */
        $result = $dic->make(ConstructorParameterWithDependency::class);
        $this->assertEquals(2, $result->value);
    }

    public function testBindInstance()
    {
        $dic = new AurynContainer();
        $instance = new NoConstructorParameter();
        $instance->value = 2;
        $dic->bindInstance(DummyInterface::class, $instance);
        /** @var NoConstructorParameter $result */
        $result = $dic->make(DummyInterface::class);
        $this->assertEquals(2, $result->value);
    }
}
