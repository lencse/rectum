<?php

namespace Test\Integration;

use Lencse\Rectum\Framework\Application\Bootstrap;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{

    public function testWeb()
    {
        $createBoostrap = require __DIR__ . '/../test-app/bootstrap/bootstrap.php';
        $renderer = new MockRenderer();
        /** @var Bootstrap $bootstrap */
        $bootstrap = $createBoostrap([
            'SERVER' => [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/',
            ],
            'GET' => [],
        ], $renderer);
        $app = $bootstrap->createWebApplication();
        $app->run();

        $response = $renderer->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getBody());
    }
}
