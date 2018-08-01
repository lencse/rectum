<?php

namespace Lencse\Rectum\Web\Routing\Configuration;

use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\Routing\Component\Route;
use Lencse\Rectum\Web\Routing\Component\RouteCollection;
use Lencse\Rectum\Web\Routing\Component\RouteHandlerPipeline;
use function is_array;

class RoutingConfigurator
{
    /**
     * @var RoutingConfig
     */
    private $config;

    public function __construct(RoutingConfig $config)
    {
        $this->config = $config;
    }

    public function __invoke(): RouteCollection
    {
        $result = [];
        foreach ($this->config->routes() as $config) {
            /** @var HttpMethod $method */
            $method = $config[0];
            /** @var string $path */
            $path = $config[1];
            /** @var array|string $pipeline */
            $pipeline = $config[2];
            /** @var string[] $handlerClasses */
            $handlerClasses = is_array($pipeline) ? $pipeline : [$pipeline];
            /** @var string[] $parameterFormats */
            $parameterFormats = $config[3] ?? [];
            $result[] = new Route(
                $method,
                $path,
                new RouteHandlerPipeline($handlerClasses),
                $parameterFormats
            );
        }

        return new RouteCollection($result);
    }
}
