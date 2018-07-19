<?php

namespace Test\Unit\Component\Web;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Web\RequestProcessor;
use Lencse\Rectum\Component\Web\RequestReader;
use Lencse\Rectum\Component\Web\ResponseRenderer;
use Lencse\Rectum\Component\Web\WebApplication;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebApplicationTest extends TestCase implements ResponseRenderer
{

    /**
     * @var ResponseInterface
     */
    private $response;

    public function render(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    public function testRun()
    {
        $app = new WebApplication(
            new class implements RequestReader
            {
                public function create(): ServerRequestInterface
                {
                    return new ServerRequest('GET', '/');
                }
            },
            new class implements RequestProcessor
            {
                public function process(ServerRequestInterface $request): ResponseInterface
                {
                    if ('/' === $request->getUri()->getPath()) {
                        return new Response(200, [], 'Test');
                    }
                }
            },
            $this
        );
        $app->run();
        $this->assertEquals([], $this->response->getHeaders());
        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('Test', (string) $this->response->getBody());
    }
}
