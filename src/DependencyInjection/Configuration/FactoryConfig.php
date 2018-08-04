<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class FactoryConfig implements Config
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $factoryClass;

    public function __construct(string $class, string $factoryClass)
    {
        $this->class = $class;
        $this->factoryClass = $factoryClass;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getFactoryClass(): string
    {
        return $this->factoryClass;
    }

    public function applyOnContainerBuilder(ContainerBuilder $builder): void
    {
        $builder->factory($this);
    }
}
