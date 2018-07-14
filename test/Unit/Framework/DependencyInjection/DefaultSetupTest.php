<?php

namespace Test\Unit\Framework\DependencyInjection;

use Lencse\Rectum\Component\DependencyInjection\Caller;
use Lencse\Rectum\Framework\DependencyInjection\AurynContainer;
use Lencse\Rectum\Framework\DependencyInjection\DefaultSetup;
use PHPUnit\Framework\TestCase;

class DefaultSetupTest extends TestCase
{

    public function testCreateContainer()
    {
        $config = new DefaultSetup();
        $dic = $config->createContainer();
        $this->assertTrue($dic instanceof AurynContainer);
    }

    public function testInjectSelf()
    {
        $config = new DefaultSetup();
        $this->assertEquals([Caller::class], $config->injectSelf());
    }
}
