<?php

namespace Lencse\Rectum\Component\Web\Routing;

class WithTransformerRouteHandlingConfig implements RouteHandlingConfig
{

    /**
     * @var string
     */
    private $requestProcessorClass;

    /**
     * @var string
     */
    private $dataTransformerClass;

    public function __construct(string $requestProcessorClass, string $dataTransformerClass)
    {
        $this->requestProcessorClass = $requestProcessorClass;
        $this->dataTransformerClass = $dataTransformerClass;
    }

    public function getRequestProcessorClass(): string
    {
        return $this->requestProcessorClass;
    }

    public function getDataTransformerClass(): string
    {
        return $this->dataTransformerClass;
    }
}
