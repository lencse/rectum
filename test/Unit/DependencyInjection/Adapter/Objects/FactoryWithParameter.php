<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class FactoryWithParameter
{
    public function __invoke(int $value): ConstructorParameter
    {
        return new ConstructorParameter($value);
    }
}
