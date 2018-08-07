<?php

namespace Lencse\Rectum\DependencyInjection\Adapter;

use Auryn\InjectionException;
use Auryn\Injector;
use function get_class;
use function is_callable;
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
use Lencse\Rectum\DependencyInjection\Configuration\InstanceConfig;
use Lencse\Rectum\DependencyInjection\Configuration\Setup;
use Lencse\Rectum\DependencyInjection\Configuration\SetupConfig;
use Psr\Container\ContainerInterface;
use RuntimeException;

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

    public function __construct(Setup $setup)
    {
        $this->auryn = new Injector();
        foreach ($setup->getConfigCollection() as $config) {
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
        // @TODO: throw exception

        $instance = $this->makeInstance($class);
        $this->auryn->share($instance);
        $this->instances[$class] = true;

        return $this->makeInstance($class);
    }

    public function has($id): bool
    {
        return class_exists($id) || interface_exists($id);
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
        // @TODO: throw exception
    }

    public function invokeWithOneParameter(string $invokableClass, $param)
    {
        $invokable = $this->get($invokableClass);
        if (!is_callable($invokable)) {
            throw new RuntimeException();
            // @TODO: throw correct exception
        }

        return $invokable($param);
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

    public function setup(SetupConfig $config): void
    {
        $params = [];
        foreach ($config->getParams() as $wireConfig) {
            $params[':' . $wireConfig->getName()] = $wireConfig->getValue();
        }
        foreach ($config->getWireConfigs() as $wireConfig) {
            $params[$wireConfig->getParameterName()] = $wireConfig->getClassName();
        }

        $this->auryn->define($config->getClass(), $params);
    }

    public function instance(InstanceConfig $config): void
    {
        $this->auryn->alias($config->getClassName(), get_class($config->getInstance()));
        $this->auryn->share($config->getInstance());
    }
}
