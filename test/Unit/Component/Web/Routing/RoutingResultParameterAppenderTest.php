<?php

namespace Test\Unit\Component\Web\Routing;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Classes\Component\Method\Parameter\FormalParameter;
use Lencse\Rectum\Classes\Component\Method\Parameter\GivenParameterType;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use Lencse\Rectum\Web\Routing\Component\RoutingResult;
use Lencse\Rectum\Web\Routing\Component\RoutingResultParameterAppender;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RoutingResultParameterAppenderTest extends TestCase
{
    public function testAppendRequestToParameters()
    {
        $appender = new RoutingResultParameterAppender(
            new class() implements MethodParameterAnalyzer {
                public function getParameters(string $class, string $method): array
                {
                    return 'Handler' === $class && '__invoke' === $method ?
                        [
                            new FormalParameter('request', new GivenParameterType(ServerRequestInterface::class)),
                            new FormalParameter('value', new GivenParameterType('int')),
                        ] : [];
                }
            }
        );
        $request = new ServerRequest('GET', '/');
        $result = $appender->appendRequestToParameters(
            new RoutingResult(
                new RouteHandlerPipeline(['Handler']),
                ['value' => 1]
            ),
            $request
        );
        $this->assertEquals(['request' => $request, 'value' => 1], $result->getParams());
    }
}
