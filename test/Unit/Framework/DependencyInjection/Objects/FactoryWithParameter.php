<?php

namespace Test\Unit\Framework\DependencyInjection\Objects;

class FactoryWithParameter
{

    public function __invoke(int $value): ConstructorParameter
    {
        return new ConstructorParameter($value);
    }
}
