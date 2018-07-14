<?php

namespace Lencse\Rectum\Framework\DependencyInjection;

use Auryn\Injector;
use Lencse\Rectum\Component\DependencyInjection\Caller;
use Lencse\Rectum\Component\DependencyInjection\Container;

class AurynContainer implements Container, Caller
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

    /**
     * @param string $callableClass
     * @param mixed[] $params
     * @return mixed
     *
     * @psalm-suppress MixedReturnStatement
     */
    public function call(string $callableClass, array $params = [])
    {
        return $this->auryn->execute($callableClass, $this->transformParameters($params));
    }

    private function makeInstance(string $class): object
    {
        /** @var object $result */
        $result = $this->auryn->make($class);

        return $result;
    }

    /**
     * @param array $params
     * @return array
     *
     * @psalm-suppress MixedAssignment
     */
    private function transformParameters(array $params): array
    {
        $result = [];
        foreach ($params as $key => $value) {
            $result[":$key"] = $value;
        }

        return $result;
    }

    public function setup(string $class, array $params = []): void
    {
        $this->auryn->define($class, $this->transformParameters($params));
    }

    public function bindInstance(string $class, object $instance): void
    {
        $this->auryn->share($instance);
        $this->bind($class, get_class($instance));
    }
}
