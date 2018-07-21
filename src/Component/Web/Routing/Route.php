<?php

namespace Lencse\Rectum\Component\Web\Routing;

use Lencse\Rectum\Component\Web\Http\HttpMethod;

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
     * @var RouteHandlerPipeline
     */
    private $handlerPipeline;

    public function __construct(HttpMethod $method, string $path, RouteHandlerPipeline $handlerPipeline)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handlerPipeline = $handlerPipeline;
    }

    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandlerPipeline(): RouteHandlerPipeline
    {
        return $this->handlerPipeline;
    }
}
