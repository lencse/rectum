<?php

namespace Lencse\Rectum\Component\Web\Routing;

use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameter;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameterAnalyzer;
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
                $this->methodParameterAnalyzer->getParameters(
                    $result->getHandlerPipeline()->first(),
                    '__invoke'
                ),
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
