<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

use Iterator;

class ConfigCollection implements Iterator
{
    /**
     * @var Config[]
     */
    private $configs = [];

    public function add(Config $config): self
    {
        $result = new self();
        $result->configs = array_merge($this->configs, [$config]);

        return $result;
    }

    public function current(): Config
    {
        return current($this->configs);
    }

    /**
     * @return false|Config
     */
    public function next()
    {
        return next($this->configs);
    }

    public function key()
    {
        return key($this->configs);
    }

    public function valid(): bool
    {
        return null !== key($this->configs) && false !== key($this->configs);
    }

    public function rewind(): void
    {
        reset($this->configs);
    }
}
