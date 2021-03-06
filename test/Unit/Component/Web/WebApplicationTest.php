<?php

namespace Test\Unit\Component\Web;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Web\Application\Component\WebApplication;
use Lencse\Rectum\Web\Request\Component\RequestSource;
use Lencse\Rectum\Web\Response\Component\ResponseRenderer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
            new class() implements RequestSource {
                public function create(): ServerRequestInterface
                {
                    return new ServerRequest('GET', '/');
                }
            },
            new class() implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request): ResponseInterface
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
