<?php

namespace Lencse\Rectum\Web\Routing\Adapter;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Lencse\Rectum\Web\Routing\Component\RouteCollection;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use Lencse\Rectum\Web\Routing\Component\Router;
use Lencse\Rectum\Web\Routing\Component\RoutingResult;
use Lencse\Rectum\Web\Routing\Exception\BadMethodException;
use Lencse\Rectum\Web\Routing\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use function FastRoute\simpleDispatcher;

class FastrouteRouter implements Router
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(RouteCollection $routes, FastRoutePath $path)
    {
        /** @var Dispatcher dispatcher */
        $this->dispatcher = simpleDispatcher(function (RouteCollector $collector) use ($routes, $path): void {
            foreach ($routes as $route) {
                $collector->addRoute(
                    (string) $route->getMethod(),
                    $path->getPathWithParameterFormats($route),
                    $route->getHandlerPipeline()
                );
            }
        });
    }

    public function route(ServerRequestInterface $request): RoutingResult
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());
        $this->validate($request, (int) $routeInfo[0]);
        /** @var RouteHandlerPipeline $handlerPipeline */
        $handlerPipeline = $routeInfo[1];
        $routeParams = (array) $routeInfo[2];

        return new RoutingResult($handlerPipeline, $routeParams);
    }

    protected function validate(ServerRequestInterface $request, int $dispatchResult): void
    {
        if (Dispatcher::METHOD_NOT_ALLOWED === $dispatchResult) {
            throw BadMethodException::create($request);
        }

        if (Dispatcher::FOUND !== $dispatchResult) {
            throw NotFoundException::create($request);
        }
    }
}
