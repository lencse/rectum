<?php

namespace Lencse\Rectum\Component\Routing;

class RoutingResult
{

    /**
     * @var string
     */
    private $handlerClass;

    /**
     * @var array
     */
    private $params;

    public function __construct(string $handlerClass, array $params)
    {
        $this->handlerClass = $handlerClass;
        $this->params = $params;
    }

    public function getHandlerClass(): string
    {
        return $this->handlerClass;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
