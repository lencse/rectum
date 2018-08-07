<?php

namespace Test\Unit\Component\Web\RequestHandler;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Classes\Component\Invoking\Invoker;
use Lencse\Rectum\Classes\Component\Method\Parameter\FormalParameter;
use Lencse\Rectum\Classes\Component\Method\Parameter\GivenParameterType;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\RequestHandler\Component\RequestHandler;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use Lencse\Rectum\Web\Routing\Component\Router;
use Lencse\Rectum\Web\Routing\Component\RoutingResult;
use Lencse\Rectum\Web\Routing\Component\RoutingResultParameterAppender;
use Lencse\Rectum\Web\Routing\Component\WebRouter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RequestHandlerTest extends TestCase
{
    public function testSimpleRouteHandling()
    {
        $handler = $this->getHandler();
        $response = $handler->handle(new ServerRequest(HttpMethod::get(), '/1'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/1-1', (string) $response->getBody());
    }

    public function testTransformedRouteHandling()
    {
        $handler = $this->getHandler();
        $response = $handler->handle(new ServerRequest(HttpMethod::get(), '/2'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('1', (string) $response->getBody());
    }

    private function getHandler(): RequestHandler
    {
        return new RequestHandler(
            new WebRouter(
                new class() implements Router {
                    public function route(ServerRequestInterface $request): RoutingResult
                    {
                        if ('/1' === $request->getUri()->getPath()) {
                            return new RoutingResult(
                                new RouteHandlerPipeline(['Handler']),
                                ['value' => 1]
                            );
                        }
                        if ('/2' === $request->getUri()->getPath()) {
                            return new RoutingResult(
                                new RouteHandlerPipeline(['DataHandler', 'Transformer']),
                                ['value' => 1]
                            );
                        }
                    }
                },
                new RoutingResultParameterAppender(
                    new class() implements MethodParameterAnalyzer {
                        public function getParameters(string $class, string $method): array
                        {
                            if ('Handler' === $class && '__invoke' === $method) {
                                return [
                                    new FormalParameter('value', new GivenParameterType('int')),
                                    new FormalParameter(
                                        'request',
                                        new GivenParameterType(ServerRequestInterface::class)
                                    ),
                                ];
                            }
                            if ('DataHandler' === $class && '__invoke' === $method) {
                                return [
                                    new FormalParameter('value', new GivenParameterType('int')),
                                    new FormalParameter(
                                        'request',
                                        new GivenParameterType(ServerRequestInterface::class)
                                    ),
                                ];
                            }
                            if ('Transformer' === $class && '__invoke' === $method) {
                                return [
                                    new FormalParameter('value', new GivenParameterType('int')),
                                    new FormalParameter(
                                        'request',
                                        new GivenParameterType(ServerRequestInterface::class)
                                    ),
                                ];
                            }
                        }
                    }
                )
            ),
            new class() implements Invoker {
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
                    if ('DataHandler' === $invokableClass) {
                        return (int) $params['value'];
                    }
                    if ('Transformer' === $invokableClass) {
                        return new Response(
                            200,
                            [],
                            (string) $params[0]
                        );
                    }
                }
            }
        );
    }
}
