<?php

namespace Lencse\Rectum\Component\Routing;

use Iterator;

class RouteCollection implements Iterator
{

    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @param Route[] $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function current(): Route
    {
        return current($this->routes);
    }

    /**
     * @return false|Route
     */
    public function next()
    {
        return next($this->routes);
    }

    public function key()
    {
        return key($this->routes);
    }

    public function valid(): bool
    {
        return null !== key($this->routes) && false !== key($this->routes);
    }

    public function rewind(): void
    {
        reset($this->routes);
    }
}
