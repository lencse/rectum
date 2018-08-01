<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class WithDependency1
{
    /**
     * @var DummyInterface
     */
    public $dependency;

    public function __construct(DummyInterface $dependency)
    {
        $this->dependency = $dependency;
    }
}
