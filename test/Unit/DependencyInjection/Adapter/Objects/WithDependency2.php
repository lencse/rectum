<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class WithDependency2
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
