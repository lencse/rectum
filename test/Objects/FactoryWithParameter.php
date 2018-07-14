<?php

namespace Test\Objects;

class FactoryWithParameter
{

    public function __invoke(int $value): ConstructorParameter
    {
        return new ConstructorParameter($value);
    }
}
