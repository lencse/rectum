<?php

namespace Lencse\Rectum\Framework\DependencyInjection;

use Auryn\Injector;
use Lencse\Rectum\Component\DependencyInjection\Caller;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Container;
use Lencse\Rectum\Component\DependencyInjection\Factory\Factory;

/**
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class AurynContainerFactory implements Factory
{

    public function createContainer(DependencyInjectionConfig $config): Container
    {
        $auryn = new Injector();
        $dic = $this->create($auryn);
        $this->setup($auryn, $config);

        $auryn->share($dic);
        $auryn->alias(Caller::class, get_class($dic));

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
            $auryn->define($class, $this->transformParameters($params));
        }
    }

    private function create(Injector $auryn): Container
    {
        return new class ($auryn) implements Container, Caller
        {

            /**
             * @var Injector
             */
            private $auryn;

            /**
             * @var bool[]
             */
            private $instances = [];

            /**
             * @param Injector $auryn
             */
            public function __construct(Injector $auryn)
            {
                $this->auryn = $auryn;
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
        };
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
}
