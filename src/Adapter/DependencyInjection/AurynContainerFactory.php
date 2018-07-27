<?php

namespace Lencse\Rectum\Adapter\DependencyInjection;

use Auryn\InjectionException;
use Auryn\Injector;
use function get_class;
use Lencse\Rectum\Component\Classes\Invoking\Invoker;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameterAnalyzer;
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

    /**
     * @var MethodParameterAnalyzer
     */
    private $methodParameterAnalyzer;

    public function __construct(
        AurynParameterTransformer $parameterTransformer,
        MethodParameterAnalyzer $methodParameterAnalyzer
    ) {
        $this->parameterTransformer = $parameterTransformer;
        $this->methodParameterAnalyzer = $methodParameterAnalyzer;
    }

    public function createContainer(DependencyInjectionConfig $config): ContainerInterface
    {
        $auryn = new Injector();
        $dic = $this->createAurynContainer($auryn);
        $this->setup($auryn, $config);
        $this->bindInvoker($auryn, $dic);

        return $dic;
    }

    private function setup(Injector $auryn, DependencyInjectionConfig $config): void
    {
        foreach ($config->bind() as $abstract => $concrete) {
            $auryn->alias($abstract, $concrete);
        }
        foreach ($config->factory() as $class => $factoryClass) {
            $auryn->delegate($class, $factoryClass);
        }
        foreach ($config->instance() as $class => $instance) {
            $auryn->alias($class, get_class($instance));
            $auryn->share($instance);
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

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    private function createAurynContainer(Injector $auryn): ContainerInterface
    {
        return new class (
            $auryn,
            $this->parameterTransformer,
            $this->methodParameterAnalyzer
        ) implements ContainerInterface, Invoker
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
             * @var MethodParameterAnalyzer
             */
            private $methodParameterAnalyzer;

            /**
             * @var bool[]
             */
            private $instances = [];

            public function __construct(
                Injector $auryn,
                AurynParameterTransformer $parameterTransformer,
                MethodParameterAnalyzer $methodParameterAnalyzer
            ) {
                $this->auryn = $auryn;
                $this->parameterTransformer = $parameterTransformer;
                $this->methodParameterAnalyzer = $methodParameterAnalyzer;
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

            public function invoke(string $invokableClass, array $params = [])
            {
                $this->get($invokableClass);

                return $this->auryn->execute(
                    $invokableClass,
                    $this->parameterTransformer->transformParameters(
                        $this->getExtendedParameters(
                            $invokableClass,
                            $params
                        )
                    )
                );
            }

            private function getExtendedParameters(string $invokableClass, array $params): array
            {
                $result = $params;
                $methodParameters = $this->methodParameterAnalyzer->getParameters($invokableClass, '__invoke');
                foreach ($methodParameters as $i => $methodParam) {
                    if (isset($params[$i]) && !isset($params[$methodParam->getName()])) {
                        $result[$methodParam->getName()] = $params[$i];
                    }
                }

                return $result;
            }

            private function makeInstance(string $class): object
            {
                return $this->auryn->make($class);
            }
        };
    }
}
