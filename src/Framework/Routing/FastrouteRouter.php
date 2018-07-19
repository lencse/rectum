<?php

namespace Lencse\Rectum\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Lencse\Rectum\Component\Routing\Exception\BadMethodException;
use Lencse\Rectum\Component\Routing\Exception\NotFoundException;
use Lencse\Rectum\Component\Routing\RouteCollection;
use Lencse\Rectum\Component\Routing\Router;
use Lencse\Rectum\Component\Routing\RoutingResult;
use Psr\Http\Message\ServerRequestInterface;

class FastrouteRouter implements Router
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(RouteCollection $routes)
    {
        /** @var Dispatcher dispatcher */
        $this->dispatcher = simpleDispatcher(function (RouteCollector $collector) use ($routes): void {
            foreach ($routes as $route) {
                $collector->addRoute(
                    (string) $route->getMethod(),
                    $route->getPath(),
                    $route->getHandlerClass()
                );
            }
        });
    }

    public function route(ServerRequestInterface $request): RoutingResult
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());
        $this->validate($request, (int) $routeInfo[0]);
        $handler = (string) $routeInfo[1];
        $routeParams = (array) $routeInfo[2];

        return new RoutingResult($handler, $routeParams);
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