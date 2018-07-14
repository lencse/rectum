<?php

namespace Test\Unit\Adapter\DependencyInjection;

use Lencse\Rectum\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use PHPUnit\Framework\TestCase;

class CompositeDependencyInjectionConfigTest extends TestCase
{

    public function testComposite()
    {
        $config = new CompositeDependencyInjectionConfig([
            new class implements DependencyInjectionConfig
            {

                public function bind(): array
                {
                    return ['A' => 'a', 'B' => 'b'];
                }

                public function factory(): array
                {
                    return ['A' => 'af'];
                }

                public function setup(): array
                {
                    return ['A' => ['a' => 1]];
                }
            },
            new class implements DependencyInjectionConfig
            {

                public function bind(): array
                {
                    return ['C' => 'c'];
                }

                public function factory(): array
                {
                    return ['B' => 'bf', 'C' => 'cf'];
                }

                public function setup(): array
                {
                    return ['B' => ['b' => 2]];
                }
            },
        ]);

        $this->assertEquals(['A' => 'a', 'B' => 'b', 'C' => 'c'], $config->bind());
        $this->assertEquals(['A' => 'af', 'B' => 'bf', 'C' => 'cf'], $config->factory());
        $this->assertEquals(['A' => ['a' => 1], 'B' => ['b' => 2]], $config->setup());
    }
}
