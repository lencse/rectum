<?php

namespace Lencse\Rectum\Web\Routing\Component;

use Lencse\Rectum\Web\Routing\Component\Router;
use Lencse\Rectum\Web\Routing\Component\RoutingResult;
use Lencse\Rectum\Web\Routing\Component\RoutingResultParameterAppender;
use Psr\Http\Message\ServerRequestInterface;

class WebRouter implements Router
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var RoutingResultParameterAppender
     */
    private $parameterAppender;

    public function __construct(Router $router, RoutingResultParameterAppender $parameterAppender)
    {
        $this->router = $router;
        $this->parameterAppender = $parameterAppender;
    }

    public function route(ServerRequestInterface $request): RoutingResult
    {
        return $this->parameterAppender->appendRequestToParameters(
            $this->router->route($request),
            $request
        );
    }
}
