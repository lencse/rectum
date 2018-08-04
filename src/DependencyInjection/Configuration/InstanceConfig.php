<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class InstanceConfig implements Config
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var object
     */
    private $instance;

    public function __construct(string $className, object $instance)
    {
        $this->className = $className;
        $this->instance = $instance;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getInstance(): object
    {
        return $this->instance;
    }

    public function applyOnContainerBuilder(ContainerBuilder $builder): void
    {
        $builder->instance($this);
    }
}
