<?php

namespace Lencse\Rectum\Component\Web\RequestHandler;

use Lencse\Rectum\Component\Classes\Invoking\Invoker;
use Lencse\Rectum\Component\Routing\Router;
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
        /** @var ResponseInterface $response */
        $response = $this->invoker->invoke($routingResult->getHandlerClass(), $routingResult->getParams());

        return $response;
    }
}
