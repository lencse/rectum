<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

use Test\Unit\DependencyInjection\Adapter\Objects\DummyInterface;

class WithDependencyAndParam2
{
    /**
     * @var DummyInterface
     */
    public $dependency;

    /**
     * @var int
     */
    private $value;

    public function __construct(DummyInterface $dependency, int $value)
    {
        $this->dependency = $dependency;
        $this->value = $value;
    }
}
