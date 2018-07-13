<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class FactoryWithParameter
{

    public function __invoke(int $value): ConstructorParameter
    {
        return new ConstructorParameter($value);
    }
}
