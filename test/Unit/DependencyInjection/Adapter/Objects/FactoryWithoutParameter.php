<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

use Test\Unit\DependencyInjection\Adapter\Objects\ConstructorParameter;

class FactoryWithoutParameter
{
    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
