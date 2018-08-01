<?php

namespace Lencse\Rectum\Web\Routing\Component;

use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameter;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Web\Routing\Component\RoutingResult;
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
