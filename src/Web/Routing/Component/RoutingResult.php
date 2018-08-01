<?php

namespace Lencse\Rectum\Web\Routing\Component;

class RoutingResult
{
    /**
     * @var RouteHandlerPipeline
     */
    private $handlerPipeline;

    /**
     * @var array
     */
    private $params;

    public function __construct(RouteHandlerPipeline $handlerPipeline, array $params)
    {
        $this->handlerPipeline = $handlerPipeline;
        $this->params = $params;
    }

    public function getHandlerPipeline(): RouteHandlerPipeline
    {
        return $this->handlerPipeline;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function withParams(array $params): self
    {
        return new self($this->handlerPipeline, $params);
    }
}
