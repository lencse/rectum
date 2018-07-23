<?php

namespace Lencse\Rectum\Framework\Web\Routing\Configuration;

class CompositeRoutingConfig implements RoutingConfig
{

    /**
     * @var RoutingConfig[]
     */
    private $configs;

    /**
     * @param RoutingConfig[] $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function routes(): array
    {
        return array_reduce(
            $this->configs,
            function (array $carry, RoutingConfig $config): array {
                return array_merge($carry, $config->routes());
            },
            []
        );
    }
}
