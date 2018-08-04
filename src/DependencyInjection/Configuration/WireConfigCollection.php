<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

use Iterator;

class WireConfigCollection implements Iterator
{
    /**
     * @var WireConfig[]
     */
    private $configs = [];

    public function add(WireConfig $config): self
    {
        $result = new self();
        $result->configs = array_merge($this->configs, [$config]);

        return $result;
    }

    public function current(): WireConfig
    {
        return current($this->configs);
    }

    /**
     * @return false|WireConfig
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
