<?php

namespace Test\Unit\Adapter\DependencyInjection;

use Lencse\Rectum\Adapter\DependencyInjection\AurynContainer;
use PHPUnit\Framework\TestCase;
use Test\Unit\Adapter\DependencyInjection\Factory\Factory;
use Test\Unit\Adapter\DependencyInjection\Factory\FactoryWithParam;
use Test\Unit\Adapter\DependencyInjection\Factory\Creatable;
use Test\Unit\Adapter\DependencyInjection\Factory\Newable;

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
        /** @var Newable $obj1 */
        $obj1 = $dic->make(Newable::class);
        /** @var Newable $obj2 */
        $obj2 = $dic->make(Newable::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory(): void
    {
        $dic = new AurynContainer();
        $dic->factory(Creatable::class, Factory::class);
        /** @var Creatable $result */
        $result = $dic->make(Creatable::class);
        $this->assertEquals(1, $result->value);
    }

    public function testCall()
    {
        $dic = new AurynContainer();
        $result = $dic->call(Factory::class);
        $this->assertTrue($result instanceof Creatable);
    }

    public function testCallWithParameters()
    {
        $dic = new AurynContainer();
        /** @var Creatable $result */
        $result = $dic->call(FactoryWithParam::class, ['value' => 2]);
        $this->assertEquals(2, $result->value);
    }
}
