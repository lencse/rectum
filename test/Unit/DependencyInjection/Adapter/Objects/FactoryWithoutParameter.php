<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class FactoryWithoutParameter
{
    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
