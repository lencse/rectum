<?php

namespace Lencse\Rectum\Component\Routing;

use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use ReflectionParameter;

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

    public function withParams(array $params): self
    {
        return new self($this->handlerClass, $params);
    }
}
