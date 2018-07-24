<?php

namespace Test\Integration;

use Lencse\Rectum\Framework\Application\Bootstrap;
use Lencse\Rectum\Testing\Web\ApplicationRunner;
use Lencse\Rectum\Testing\Web\Response\ResponseObserver;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{

    public function testWeb()
    {
        $runner = new ApplicationRunner(__DIR__ . '/../test-app');
        $response = $runner->runWithSuperGlobals([
            'SERVER' => [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/',
            ],
            'GET' => [],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getBody());
    }
}
