<?php

namespace Lencse\Rectum\Framework\DependencyInjection;

use Auryn\InjectionException;
use Auryn\Injector;
use function get_class;
use Lencse\Rectum\Component\DependencyInjection\Invoker;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Factory\ContainerFactory;
use Psr\Container\ContainerInterface;

/**
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class AurynContainerFactory implements ContainerFactory
{

    /**
     * @var AurynParameterTransformer
     */
    private $parameterTransformer;

    public function __construct(AurynParameterTransformer $parameterTransformer)
    {
        $this->parameterTransformer = $parameterTransformer;
    }

    public function createContainer(DependencyInjectionConfig $config): ContainerInterface
    {
        $auryn = new Injector();
        $dic = $this->createAurynContainer($auryn);
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

        $wireConfig = $config->wire();
        $setupConfig = $config->setup();
        /** @var string[] $defineClasses */
        $defineClasses = array_merge(array_keys($wireConfig), array_keys($setupConfig));

        foreach ($defineClasses as $class) {
            $wire = $wireConfig[$class] ?? [];
            $setup = $this->parameterTransformer->transformParameters($setupConfig[$class] ?? []);
            $auryn->define($class, array_merge($wire, $setup));
        }
    }

    private function bindInvoker(Injector $auryn, ContainerInterface $dic): void
    {
        $auryn->share($dic);
        $auryn->alias(Invoker::class, get_class($dic));
    }

    private function createAurynContainer(Injector $auryn): ContainerInterface
    {
        return new class ($auryn, $this->parameterTransformer) implements ContainerInterface, Invoker
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

            /**
             * @param string $invokableClass
             * @param mixed[] $params
             * @return mixed
             *
             * @psalm-suppress MixedReturnStatement
             */
            public function invoke(string $invokableClass, array $params = [])
            {
                return $this->auryn->execute(
                    $invokableClass,
                    $this->parameterTransformer->transformParameters($params)
                );
            }

            private function makeInstance(string $class): object
            {
                /** @var object $result */
                $result = $this->auryn->make($class);

                return $result;
            }
        };
    }
}
