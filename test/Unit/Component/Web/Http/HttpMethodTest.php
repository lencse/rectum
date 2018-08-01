<?php

namespace Test\Unit\Component\Web\Http;

use Lencse\Rectum\Web\Http\Component\HttpMethod;
use PHPUnit\Framework\TestCase;

class HttpMethodTest extends TestCase
{
    public function testHttpMethod()
    {
        $methods = [
            'HEAD',
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'PURGE',
            'OPTIONS',
            'TRACE',
            'CONNECT',
        ];
        foreach ($methods as $method) {
            $call = strtolower($method);
            $this->assertEquals($method, (string) HttpMethod::$call());
        }
    }
}
