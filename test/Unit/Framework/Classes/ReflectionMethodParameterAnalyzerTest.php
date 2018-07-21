<?php

namespace Test\Unit\Framework\Classes;

use Lencse\Rectum\Framework\Classes\Method\Parameter\ReflectionMethodParameterAnalyzer;
use PHPUnit\Framework\TestCase;

class ReflectionMethodParameterAnalyzerTest extends TestCase
{

    public function doSomething(ReflectionMethodParameterAnalyzerTest $test, $dummy)
    {
        return [$test, $dummy];
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
    }
}
