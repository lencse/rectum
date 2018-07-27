<?php

namespace Test\Unit\Adapter\Web\Request;

use Lencse\Rectum\Adapter\Web\Request\FromGlobalsRequestReader;
use PHPUnit\Framework\TestCase;

class FromGlobalsRequestReaderTest extends TestCase
{
    public function testCreate()
    {
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/'
        ];
        $get = [
            'value' => '1'
        ];

        $reader = new FromGlobalsRequestReader($server, $get);
        $request = $reader->create();
        $this->assertEquals('/', $request->getUri()->getPath());
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(['value' => '1'], $request->getQueryParams());
    }
}
