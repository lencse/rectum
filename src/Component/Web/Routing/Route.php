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

    /**
     * @var string[]
     */
    private $parameterFormats;

    /**
     * @param HttpMethod $method
     * @param string $path
     * @param RouteHandlerPipeline $handlerPipeline
     * @param string[] $parameterFormats
     */
    public function __construct(
        HttpMethod $method,
        string $path,
        RouteHandlerPipeline $handlerPipeline,
        array $parameterFormats = []
    ) {
        $this->method = $method;
        $this->path = $path;
        $this->handlerPipeline = $handlerPipeline;
        $this->parameterFormats = $parameterFormats;
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

    /**
     * @return string[]
     */
    public function getParameterFormats(): array
    {
        return $this->parameterFormats;
    }
}
