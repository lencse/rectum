<?php

namespace Lencse\Rectum\Web\RequestHandler\Component;

use Lencse\Rectum\Classes\Component\Invoking\Invoker;
use Lencse\Rectum\Web\Routing\Component\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Invoker
     */
    private $invoker;

    public function __construct(Router $router, Invoker $invoker)
    {
        $this->router = $router;
        $this->invoker = $invoker;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routingResult = $this->router->route($request);
        $params = $routingResult->getParams();
        foreach ($routingResult->getHandlerPipeline() as $handler) {
            $result = $this->invoker->invoke($handler, $params);
            $params = [$result];
        }

        return $result;
    }
}
