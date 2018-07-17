<?php

namespace Lencse\Rectum\Framework\DependencyInjection;

use Auryn\Injector;
use Lencse\Rectum\Component\DependencyInjection\Invoker;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Container;
use Lencse\Rectum\Component\DependencyInjection\Factory\ContainerFactory;

/**
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class AurynrContainerFactory implements ContainerFactory
{

    /**
     * @var AurynParameterTransformer
     */
    private $parameterTransformer;

    public function __construct(AurynParameterTransformer $parameterTransformer)
    {
        $this->parameterTransformer = $parameterTransformer;
    }

    public function createContainer(DependencyInjectionConfig $config): Container
    {
        $auryn = new Injector();
        $dic = $this->create($auryn);
        $this->setup($auryn, $config);
        $this->bindInvoker($auryn, $dic);

        return $dic;
    }

    /**
     * @psalm-suppress MixedArgument
     */
    private function setup(Injector $auryn, DependencyInjectionConfig $config): void
    {
        foreach ($config->bind() as $abstract => $concrete) {
            $auryn->alias($abstract, $concrete);
        }
        foreach ($config->factory() as $class => $factoryClass) {
            $auryn->delegate($class, $factoryClass);
        }
        foreach ($config->setup() as $class => $params) {
            $auryn->define($class, $this->parameterTransformer->transformParameters($params));
        }
    }

    private function bindInvoker(Injector $auryn, Container $dic): void
    {
        $auryn->share($dic);
        $auryn->alias(Invoker::class, get_class($dic));
    }

    private function create(Injector $auryn): Container
    {
        return new class ($auryn, $this->parameterTransformer) implements Container, Invoker
        {

            /**
             * @var Injector
             */
            private $auryn;

            /**
             * @var AurynParameterTransformer
             */
            private $parameterTransformer;

            /**
             * @var bool[]
             */
            private $instances = [];

            public function __construct(Injector $auryn, AurynParameterTransformer $parameterTransformer)
            {
                $this->auryn = $auryn;
                $this->parameterTransformer = $parameterTransformer;
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

            private function makeInstance(string $class): object
            {
                /** @var object $result */
                $result = $this->auryn->make($class);

                return $result;
            }

            /**
             * @param string $invokableClass
             * @param mixed[] $params
             * @return mixed
             *
             * @psalm-suppress MixedReturnStatement
             */
            public function call(string $invokableClass, array $params = [])
            {
                return $this->auryn->execute(
                    $invokableClass,
                    $this->parameterTransformer->transformParameters($params)
                );
            }
        };
    }
}
