<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class ConstructorParameter
{

    /**
     * @var int
     */
    public $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
