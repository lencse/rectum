<?php

namespace Test\Unit\Web;

use Lencse\Rectum\Component\Web\RequestReader;
use PHPUnit\Framework\TestCase;

class RequestReaderTest extends TestCase
{

    public function testCreateFromGlobals()
    {
        $reader = new RequestReader();

        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/'
        ];
        $get = [
            'value' => '1'
        ];

        $request = $reader->createFromGlobals($server, $get);
        $this->assertEquals('/', $request->getUri()->getPath());
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(['value' => '1'], $request->getQueryParams());
    }
}
