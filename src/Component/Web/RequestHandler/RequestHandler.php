<?php

namespace Lencse\Rectum\Component\Web\RequestHandler;

use Lencse\Rectum\Component\Classes\Invoking\Invoker;
use Lencse\Rectum\Component\Web\Routing\Router;
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

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedReturnStatement
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routingResult = $this->router->route($request);

        $data = $this->invoker->invoke(
            $routingResult->getHandlingConfig()->getRequestProcessorClass(),
            $routingResult->getParams()
        );

        if ('' === $routingResult->getHandlingConfig()->getDataTransformerClass()) {
            return $data;
        }

        $response = $this->invoker->invoke(
            $routingResult->getHandlingConfig()->getDataTransformerClass(),
            ['data' => $data]
        );

        return $response;
    }
}
