<?php

namespace Lencse\Rectum\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Lencse\Rectum\Component\Routing\Exception\NotFoundException;
use Lencse\Rectum\Component\Routing\RouteCollection;
use Lencse\Rectum\Component\Routing\Router;
use Lencse\Rectum\Component\Routing\RoutingResult;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use ReflectionParameter;

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
                $collector->addRoute('GET', $route->getPath(), $route->getHandlerClass());
            }
        });
    }

    public function route(ServerRequestInterface $request): RoutingResult
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());


        if (Dispatcher::FOUND !== $routeInfo[0]) {
            throw NotFoundException::create($request);
        }

        $handler = (string) $routeInfo[1];
        $routeParams = (array) $routeInfo[2];

        if (class_exists($handler)) {
            $reflection = new ReflectionClass($handler);
            /** @var ReflectionParameter[] $params */
            $params = $reflection->getMethod('__invoke')->getParameters();
            foreach ($params as $param) {
                if (null !==$param->getType() && ServerRequestInterface::class === $param->getType()->getName()) {
                    $routeParams[$param->getName()] = $request;
                }
            }
        }

        return new RoutingResult($handler, $routeParams);
    }
}
