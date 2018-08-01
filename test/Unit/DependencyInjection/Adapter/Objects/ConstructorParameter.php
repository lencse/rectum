<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

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
