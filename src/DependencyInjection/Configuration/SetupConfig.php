<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

use Lencse\Rectum\Classes\Component\Method\Parameter\ActualParameter;
use Lencse\Rectum\Classes\Component\Method\Parameter\ActualParameterCollection;

class SetupConfig implements Config
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var ActualParameterCollection
     */
    private $params;

    /**
     * @var WireConfigCollection
     */
    private $wireConfigs;

    public function __construct(string $class)
    {
        $this->class = $class;
        $this->params = new ActualParameterCollection();
        $this->wireConfigs = new WireConfigCollection();
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getParams(): ActualParameterCollection
    {
        return $this->params;
    }

    public function getWireConfigs(): WireConfigCollection
    {
        return $this->wireConfigs;
    }

    public function param(string $name, $value): self
    {
        $result = $this->copy();
        $result->params = $this->params->add(new ActualParameter($name, $value));

        return $result;
    }

    public function wire(string $parameterName, string $className): self
    {
        $result = $this->copy();
        $result->wireConfigs = $this->wireConfigs->add(new WireConfig($parameterName, $className));

        return $result;
    }

    public function applyOnContainerBuilder(ContainerBuilder $builder): void
    {
        $builder->setup($this);
    }

    private function copy(): self
    {
        $result = new self($this->class);
        $result->params = $this->params;
        $result->wireConfigs = $this->wireConfigs;

        return $result;
    }
}
