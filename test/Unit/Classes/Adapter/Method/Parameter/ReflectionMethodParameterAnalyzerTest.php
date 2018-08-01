<?php

namespace Test\Unit\Classes\Adapter\Method\Parameter;

use DateTimeInterface;
use Lencse\Rectum\Classes\Adapter\Method\Parameter\ReflectionMethodParameterAnalyzer;
use PHPUnit\Framework\TestCase;

class ReflectionMethodParameterAnalyzerTest extends TestCase
{
    public function doSomething(self $test, $dummy, DateTimeInterface $date)
    {
        return [$test, $dummy, $date];
    }

    public function testGetParameters()
    {
        $analyzer = new ReflectionMethodParameterAnalyzer();
        $params = $analyzer->getParameters(self::class, 'doSomething');

        $this->assertEquals('test', $params[0]->getName());
        $this->assertTrue($params[0]->getType()->match(self::class));
        $this->assertFalse($params[0]->getType()->match(ReflectionMethodParameterAnalyzer::class));

        $this->assertEquals('dummy', $params[1]->getName());
        $this->assertFalse($params[1]->getType()->match(self::class));

        $this->assertEquals('date', $params[2]->getName());
        $this->assertTrue($params[2]->getType()->match(DateTimeInterface::class));
    }
}
