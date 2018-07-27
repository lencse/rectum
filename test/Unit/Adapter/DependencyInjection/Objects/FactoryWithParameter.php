<?php

namespace Test\Unit\Adapter\DependencyInjection\Objects;

class FactoryWithParameter
{
    public function __invoke(int $value): ConstructorParameter
    {
        return new ConstructorParameter($value);
    }
}
