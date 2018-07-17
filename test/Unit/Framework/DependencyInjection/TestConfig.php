<?php

namespace Test\Unit\Framework\DependencyInjection;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;

class TestConfig implements DependencyInjectionConfig
{

    /**
     * @var array[]
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function bind(): array
    {
        return $this->config['bind'] ?? [];
    }

    public function factory(): array
    {
        return $this->config['factory'] ?? [];
    }

    public function setup(): array
    {
        return $this->config['setup'] ?? [];
    }
}
