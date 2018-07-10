<?php

namespace Lencse\Rectum\Adapter\DependencyInjection;

use Auryn\Injector;
use Lencse\Rectum\DependencyInjection\Container;

class AurynContainer implements Container
{

    /**
     * @var Injector
     */
    private $auryn;

    /**
     * @var array
     */
    private $instances = [];

    public function __construct()
    {
        $this->auryn = new Injector();
    }

    public function make(string $class): object
    {
        if (isset($this->instances[$class])) {
            return $this->makeInstance($class);
        }

        $instance = $this->makeInstance($class);
        $this->auryn->share($instance);
        $this->instances[$class] = true;

        return $this->makeInstance($class);
    }

    public function bind(string $abstract, string $concrete): void
    {
        $this->auryn->alias($abstract, $concrete);
    }

    public function factory(string $class, string $factoryClass): void
    {
        $this->auryn->delegate($class, $factoryClass);
    }

    private function makeInstance(string $class): object
    {
        /** @var object $result */
        $result = $this->auryn->make($class);

        return $result;
    }
}
