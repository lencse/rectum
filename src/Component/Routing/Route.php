<?php

namespace Lencse\Rectum\Component\Routing;

use Lencse\Rectum\Component\Http\HttpMethod;

class Route
{

    /**
     * @var HttpMethod
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $handlerClass;

    public function __construct(HttpMethod $method, string $path, string $handlerClass)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handlerClass = $handlerClass;
    }

    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandlerClass(): string
    {
        return $this->handlerClass;
    }
}
