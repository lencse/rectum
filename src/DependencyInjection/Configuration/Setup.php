<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class Setup
{

    /**
     * @var ConfigCollection
     */
    private $configs;

    public function __construct()
    {
        $this->configs = new ConfigCollection();
    }

    public function append(ConfigCollection $configs): self
    {
        $result = new self();
        $result->configs = $this->configs->append($configs);

        return $result;
    }

    public function add(Config $config): self
    {
        $result = new self();
        $result->configs = $this->configs->add($config);

        return $result;
    }

    public function getConfigCollection(): ConfigCollection
    {
        return $this->configs;
    }
}
