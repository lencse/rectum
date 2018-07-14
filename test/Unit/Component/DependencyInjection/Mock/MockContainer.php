<?php

namespace Test\Unit\Component\DependencyInjection\Mock;

use Lencse\Rectum\Component\DependencyInjection\Caller;
use Lencse\Rectum\Component\DependencyInjection\Container;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class MockContainer implements Container, Caller
{

    /**
     * @var object[]
     */
    public $shared = [];

    /**
     * @var string[]
     */
    public $bound = [];

    /**
     * @var string[]
     */
    public $factories = [];

    /**
     * @var mixed[][]
     */
    public $setupParams = [];

    public function call(string $callableClass, array $params = [])
    {
    }

    public function make(string $class): object
    {
        return $this;
    }

    public function bind(string $abstract, string $concrete): void
    {
        $this->bound[$abstract] = $concrete;
    }

    public function factory(string $class, string $factoryClass): void
    {
        $this->factories[$class] = $factoryClass;
    }

    public function setup(string $class, array $params = []): void
    {
        $this->setupParams[$class] = $params;
    }

    public function bindInstance(string $class, object $instance): void
    {
        $this->shared[$class] = $instance;
    }
}
