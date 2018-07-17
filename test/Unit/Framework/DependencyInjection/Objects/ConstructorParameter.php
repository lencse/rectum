<?php

namespace Test\Unit\Framework\DependencyInjection\Objects;

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
