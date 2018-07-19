<?php

namespace Test\Unit\Component\Routing;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Classes\GivenParameterType;
use Lencse\Rectum\Component\Classes\MethodParameter;
use Lencse\Rectum\Component\Classes\MethodParameterAnalyzer;
use Lencse\Rectum\Component\Routing\RoutingResult;
use Lencse\Rectum\Component\Routing\RoutingResultParameterAppender;
use Lencse\Rectum\Framework\Classes\ReflectionMethodParameterAnalyzer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Test\Unit\Component\Routing\Handler\TestHandler;

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
        $result = $appender->appendRequestToParameters(new RoutingResult('Handler', ['value' => 1]), $request);
        $this->assertEquals(['request' => $request, 'value' => 1], $result->getParams());
    }
}