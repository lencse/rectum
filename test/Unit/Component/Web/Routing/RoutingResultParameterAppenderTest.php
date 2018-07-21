<?php

namespace Test\Unit\Component\Web\Routing;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Classes\Method\Parameter\GivenParameterType;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameter;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
use Lencse\Rectum\Component\Web\Routing\RoutingResult;
use Lencse\Rectum\Component\Web\Routing\RoutingResultParameterAppender;
use Lencse\Rectum\Component\Web\Routing\SimpleRouteHandlingConfig;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RoutingResultParameterAppenderTest extends TestCase
{

    public function testAppendRequestToParameters()
    {
        $appender = new RoutingResultParameterAppender(
            new class implements MethodParameterAnalyzer
            {

                public function getParameters(string $class, string $method): array
                {
                    return 'Handler' === $class && '__invoke' === $method ?
                        [
                            new MethodParameter('request', new GivenParameterType(ServerRequestInterface::class)),
                            new MethodParameter('value', new GivenParameterType('int')),
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
