<?php

namespace Test\Unit\Web\Request\Adapter;

use Lencse\Rectum\Web\Request\Adapter\FromGlobalsRequestSource;
use PHPUnit\Framework\TestCase;

class FromGlobalsRequestSourceTest extends TestCase
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

        $reader = new FromGlobalsRequestSource($server, $get);
        $request = $reader->create();
        $this->assertEquals('/', $request->getUri()->getPath());
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(['value' => '1'], $request->getQueryParams());
    }
}
