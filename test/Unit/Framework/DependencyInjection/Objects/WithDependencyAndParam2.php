<?php

namespace Test\Unit\Framework\DependencyInjection\Objects;

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