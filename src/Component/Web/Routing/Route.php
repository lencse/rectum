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
     * @var RouteHandlingConfig
     */
    private $handlingConfig;

    public function __construct(HttpMethod $method, string $path, RouteHandlingConfig $handlingConfig)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handlingConfig = $handlingConfig;
    }

    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return RouteHandlingConfig
     */
    public function getHandlingConfig(): RouteHandlingConfig
    {
        return $this->handlingConfig;
    }
}
