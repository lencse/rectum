<?php

namespace Test\Integration;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Web\Request\RequestReader;
use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Lencse\Rectum\Component\Web\WebApplication;
use Lencse\Rectum\Framework\Application\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @group only
 */
class WebTest extends TestCase
{

    public function testWeb()
    {
        $config = require 'test-app/config/configuration.php';
        $dicExtra = new class implements DependencyInjectionConfig
        {
            public function bind(): array
            {
                return [
                    ResponseRenderer::class => MockRenderer::class
                ];
            }

            public function factory(): array
            {
                return [];
            }

            public function setup(): array
            {
                return [
                    FromGlobalsRequestReader::class => [
                        'serverArr' => [
                            'REQUEST_METHOD' => 'GET',
                            'REQUEST_URI' => '/',
                        ],
                        'getArr' => [],
                    ]
                ];
            }

            public function wire(): array
            {
                return [];
            }
        };
        $bootstrap = new Bootstrap($config($dicExtra));
        $app = $bootstrap->createWebApplication();
        $app->run();

        $response = MockRenderer::$response;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getBody());
    }
}
