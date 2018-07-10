<?php

namespace Test\Unit\Adapter\DependencyInjection;

use Lencse\Rectum\Adapter\DependencyInjection\AurynContainer;
use PHPUnit\Framework\TestCase;
use Test\Unit\Adapter\DependencyInjection\Factory\Factory;
use Test\Unit\Adapter\DependencyInjection\Factory\MadeByFactory;

class AurynContainerTest extends TestCase
{

    /**
     * @var int
     */
    public $value = 0;

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
        /** @var self $obj1 */
        $obj1 = $dic->make(self::class);
        /** @var self $obj2 */
        $obj2 = $dic->make(self::class);
        $obj1->value = 1;
        $this->assertEquals(1, $obj2->value);
    }

    public function testFactory(): void
    {
        $dic = new AurynContainer();
        $dic->factory(MadeByFactory::class, Factory::class);
        /** @var MadeByFactory $result */
        $result = $dic->make(MadeByFactory::class);
        $this->assertEquals(1, $result->value);
    }
}
