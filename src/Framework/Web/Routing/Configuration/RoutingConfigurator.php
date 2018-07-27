<?php

namespace Lencse\Rectum\Framework\Web\Routing\Configuration;

use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Component\Web\Routing\Route;
use Lencse\Rectum\Component\Web\Routing\RouteCollection;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
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
