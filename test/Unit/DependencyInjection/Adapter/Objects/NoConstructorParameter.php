<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class NoConstructorParameter implements DummyInterface
{
    /**
     * @var int
     */
    public $value = 0;
}
