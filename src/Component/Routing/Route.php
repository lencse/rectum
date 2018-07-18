<?php

namespace Lencse\Rectum\Component\Routing;

class Route
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $handlerClass;

    public function __construct(string $path, string $handlerClass)
    {
        $this->path = $path;
        $this->handlerClass = $handlerClass;
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
