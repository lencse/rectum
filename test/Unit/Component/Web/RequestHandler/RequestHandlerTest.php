<?php

namespace Test\Unit\Component\Web\RequestHandler;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Classes\Method\Parameter\GivenParameterType;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameter;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Component\Classes\Invoking\Invoker;
use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Web\Routing\Router;
use Lencse\Rectum\Component\Web\Routing\RoutingResult;
use Lencse\Rectum\Component\Web\Routing\RoutingResultParameterAppender;
use Lencse\Rectum\Component\Web\Routing\WebRouter;
use Lencse\Rectum\Component\Web\RequestHandler\RequestHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RequestHandlerTest extends TestCase
{

    public function testProcess()
    {
        $processor = new RequestHandler(
            new WebRouter(
                new class implements Router
                {
                    public function route(ServerRequestInterface $request): RoutingResult
                    {
                        if ('/1' === $request->getUri()->getPath()) {
                            return new RoutingResult('Handler', ['value' => 1]);
                        }
                    }
                },
                new RoutingResultParameterAppender(
                    new class implements MethodParameterAnalyzer
                    {
                        public function getParameters(string $class, string $method): array
                        {
                            if ('Handler' === $class && '__invoke' === $method) {
                                return [
                                    new MethodParameter('value', new GivenParameterType('int')),
                                    new MethodParameter(
                                        'request',
                                        new GivenParameterType(ServerRequestInterface::class)
                                    ),
                                ];
                            }
                        }
                    }
                )
            ),
            new class implements Invoker
            {
                public function invoke(string $invokableClass, array $params = [])
                {
                    if ('Handler' === $invokableClass) {
                        /** @var ServerRequestInterface $request */
                        $request = $params['request'];
                        return new Response(
                            200,
                            [],
                            sprintf('%s-%s', $request->getUri()->getPath(), (string) $params['value'])
                        );
                    }
                }
            }
        );

        $response = $processor->handle(new ServerRequest(HttpMethod::get(), '/1'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/1-1', (string) $response->getBody());
    }
}
