<?php

namespace Test\Integration;

use Lencse\Rectum\Testing\Facade\AppTesting;
use Lencse\Rectum\Testing\Web\ApplicationRunner;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{

    public function testWeb()
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
    }
}
