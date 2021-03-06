<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class ConstructorParameterWithDependency
{
    /**
     * @var int
     */
    public $value;

    /**
     * @var DummyInterface
     */
    public $dependency;

    public function __construct(DummyInterface $dependency, int $value)
    {
        $this->dependency = $dependency;
        $this->value = $value;
    }
}
