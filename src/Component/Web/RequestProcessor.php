<?php

namespace Lencse\Rectum\Component\Web;

use Lencse\Rectum\Component\DependencyInjection\Invoker;
use Lencse\Rectum\Component\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestProcessor
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

    public function process(ServerRequestInterface $request): ResponseInterface
    {
        $routingResult = $this->router->route($request);
        /** @var ResponseInterface $response */
        $response = $this->invoker->call($routingResult->getHandlerClass(), $routingResult->getParams());

        return $response;
    }
}
