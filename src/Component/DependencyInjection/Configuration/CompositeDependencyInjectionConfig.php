<?php

namespace Lencse\Rectum\Component\DependencyInjection\Configuration;

use Closure;

class CompositeDependencyInjectionConfig implements DependencyInjectionConfig
{

    /**
     * @var DependencyInjectionConfig[]
     */
    private $configs;

    /**
     * @param DependencyInjectionConfig[] $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function bind(): array
    {
        return $this->merge(function (DependencyInjectionConfig $config): array {
            return $config->bind();
        });
    }

    public function factory(): array
    {
        return $this->merge(function (DependencyInjectionConfig $config): array {
            return $config->factory();
        });
    }

    public function setup(): array
    {
        return $this->merge(function (DependencyInjectionConfig $config): array {
            return $config->setup();
        });
    }

    public function wire(): array
    {
        return $this->merge(function (DependencyInjectionConfig $config): array {
            return $config->wire();
        });
    }

    private function merge(Closure $closure): array
    {
        return array_reduce(
            $this->configs,
            function (array $carry, DependencyInjectionConfig $config) use ($closure): array {
                return array_merge($carry, $closure->call($this, $config));
            },
            []
        );
    }
}
