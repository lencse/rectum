<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

use Test\Unit\DependencyInjection\Adapter\Objects\DummyInterface;

class NoConstructorParameter implements DummyInterface
{
    /**
     * @var int
     */
    public $value = 0;
}
