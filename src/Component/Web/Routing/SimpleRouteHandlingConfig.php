<?php

namespace Lencse\Rectum\Component\Web\Routing;

class SimpleRouteHandlingConfig implements RouteHandlingConfig
{

    /**
     * @var string
     */
    private $requestProcessorClass;

    public function __construct(string $requestProcessorClass)
    {
        $this->requestProcessorClass = $requestProcessorClass;
    }

    public function getRequestProcessorClass(): string
    {
        return $this->requestProcessorClass;
    }

    public function getDataTransformerClass(): string
    {
        return '';
    }
}
