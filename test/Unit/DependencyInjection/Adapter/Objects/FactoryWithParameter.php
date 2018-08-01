<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

use Test\Unit\DependencyInjection\Adapter\Objects\ConstructorParameter;

class FactoryWithParameter
{
    public function __invoke(int $value): ConstructorParameter
    {
        return new ConstructorParameter($value);
    }
}
