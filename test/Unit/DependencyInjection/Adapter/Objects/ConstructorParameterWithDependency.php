<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

use Test\Unit\DependencyInjection\Adapter\Objects\DummyInterface;

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
