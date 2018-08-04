<?php

namespace Lencse\Rectum\DependencyInjection\Adapter;

use Auryn\InjectionException;
use Auryn\Injector;
use function get_class;
use Lencse\Rectum\Classes\Adapter\Method\Parameter\ReflectionMethodParameterAnalyzer;
use Lencse\Rectum\Classes\Component\Invoking\Invoker2;
use Lencse\Rectum\Classes\Component\Method\Parameter\ActualParameterCollection;
use Lencse\Rectum\DependencyInjection\Adapter\AurynParameterTransformer;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\DependencyInjection\Configuration\BindConfig;
use Lencse\Rectum\DependencyInjection\Configuration\ConfigCollection;
use Lencse\Rectum\DependencyInjection\Configuration\ContainerBuilder;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\DependencyInjection\Component\Factory\ContainerFactory;
use Lencse\Rectum\DependencyInjection\Configuration\FactoryConfig;
use Psr\Container\ContainerInterface;

class AurynContainer implements ContainerInterface, ContainerBuilder, Invoker2
{
    /**
     * @var Injector
     */
    private $auryn;

    /**
     * @var bool[]
     */
    private $instances = [];

    public function __construct(ConfigCollection $configs)
    {
        $this->auryn = new Injector();
        foreach ($configs as $config) {
            $config->applyOnContainerBuilder($this);
        }

        $this->auryn->share($this);
        $this->auryn->alias(Invoker2::class, get_class($this));
    }

    public function get($id): object
    {
        $class = (string) $id;
        if (isset($this->instances[$class])) {
            return $this->makeInstance($class);
        }

        $instance = $this->makeInstance($class);
        $this->auryn->share($instance);
        $this->instances[$class] = true;

        return $this->makeInstance($class);
    }

    public function has($id): bool
    {
        try {
            $this->auryn->make((string) $id);
        } catch (InjectionException $e) {
            return false;
        }

        return true;
    }

    public function invoke(string $invokableClass, ActualParameterCollection $params)
    {
        $this->get($invokableClass);
        $transformedParameters = [];
        foreach ($params as $param) {
            $transformedParameters[':' . $param->getName()] = $param->getValue();
        }

        return $this->auryn->execute(
            $invokableClass,
            $transformedParameters
        );
    }

    public function invokeWithOneParameter(string $invokableClass, $param)
    {
        return $this->get($invokableClass)($param);
    }

    private function makeInstance(string $class): object
    {
        return $this->auryn->make($class);
    }

    public function bind(BindConfig $config): void
    {
        $this->auryn->alias($config->getAbstract(), $config->getConcrete());
    }

    public function factory(FactoryConfig $config): void
    {
        $this->auryn->delegate($config->getClass(), $config->getFactoryClass());
    }
}
