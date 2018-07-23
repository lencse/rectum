<?php

namespace Test\Integration;

use Lencse\Rectum\Framework\Application\Bootstrap;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{

    public function testWeb()
    {
        $createBoostrap = require __DIR__ . '/test-app/bootstrap/bootstrap.php';
        /** @var Bootstrap $bootstrap */
        $bootstrap = $createBoostrap([
            'SERVER' => [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/',
            ],
            'GET' => [],
        ]);
        $app = $bootstrap->createWebApplication();
        $app->run();

        $response = MockRenderer::$response;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getBody());
    }
}
