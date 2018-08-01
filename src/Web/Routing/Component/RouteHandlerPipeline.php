<?php

namespace Lencse\Rectum\Web\Routing\Component;

use Iterator;
use Lencse\Rectum\Web\Routing\Exception\EmptyRouteHandlerPipelineException;

class RouteHandlerPipeline implements Iterator
{
    /**
     * @var string[]
     */
    private $handlerClasses;

    /**
     * @param string[] $handlerClasses
     */
    public function __construct(array $handlerClasses)
    {
        if (!count($handlerClasses)) {
            throw new EmptyRouteHandlerPipelineException();
        }
        $this->handlerClasses = $handlerClasses;
    }

    public function current(): string
    {
        return current($this->handlerClasses);
    }

    /**
     * @return false|string
     */
    public function next()
    {
        return next($this->handlerClasses);
    }

    public function key()
    {
        return key($this->handlerClasses);
    }

    public function valid(): bool
    {
        return null !== key($this->handlerClasses) && false !== key($this->handlerClasses);
    }

    public function rewind(): void
    {
        reset($this->handlerClasses);
    }

    public function first(): string
    {
        return $this->handlerClasses[0];
    }
}
