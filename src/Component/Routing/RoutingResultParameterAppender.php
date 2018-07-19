<?php

namespace Lencse\Rectum\Component\Routing;

use Lencse\Rectum\Component\Classes\MethodParameter;
use Lencse\Rectum\Component\Classes\MethodParameterAnalyzer;
use Psr\Http\Message\ServerRequestInterface;

class RoutingResultParameterAppender
{

    /**
     * @var MethodParameterAnalyzer
     */
    private $methodParameterAnalyzer;

    public function __construct(MethodParameterAnalyzer $methodParameterAnalyzer)
    {
        $this->methodParameterAnalyzer = $methodParameterAnalyzer;
    }

    public function appendRequestToParameters(RoutingResult $result, ServerRequestInterface $request): RoutingResult
    {
        $append = array_reduce(
            array_filter(
                $this->methodParameterAnalyzer->getParameters($result->getHandlerClass(), '__invoke'),
                function (MethodParameter $parameter): bool {
                    return $parameter->getType()->match(ServerRequestInterface::class);
                }
            ),
            function (array $carry, MethodParameter $parameter) use ($request) : array {
                return array_merge($carry, [$parameter->getName() => $request]);
            },
            []
        );

        return $result->withParams(array_merge($result->getParams(), $append));
    }
}
