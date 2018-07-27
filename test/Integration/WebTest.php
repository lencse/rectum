<?php

namespace Test\Integration;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Testing\Facade\AppTesting;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{
    public function testSuperGlobals()
    {
        $response = AppTesting::webApplication()
             ->withSuperGlobals([
                 'SERVER' => [
                     'REQUEST_METHOD' => 'GET',
                     'REQUEST_URI' => '/',
                 ],
                 'GET' => [],
             ])
             ->run();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getBody());
        $this->assertEquals(['text/plain'], $response->getHeader('Content-Type'));
    }

    public function testRequests()
    {
        $response = AppTesting::webApplication()
             ->withRequest(new ServerRequest(
                 'GET',
                 '/hello/Lencse'
             ))
             ->run();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Hello, Lencse!', $response->getBody());
        $this->assertEquals(['text/plain'], $response->getHeader('Content-Type'));
    }
}
