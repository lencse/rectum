<?php

namespace Lencse\Rectum\Component\Web\Routing;

class RoutingResult
{

    /**
     * @var RouteHandlingConfig
     */
    private $handlingConfig;

    /**
     * @var array
     */
    private $params;

    public function __construct(RouteHandlingConfig $handlingConfig, array $params)
    {
        $this->handlingConfig = $handlingConfig;
        $this->params = $params;
    }

    public function getHandlingConfig(): RouteHandlingConfig
    {
        return $this->handlingConfig;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function withParams(array $params): self
    {
        return new self($this->handlingConfig, $params);
    }
}
