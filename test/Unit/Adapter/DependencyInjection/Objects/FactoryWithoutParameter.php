<?php

namespace Test\Unit\Adapter\DependencyInjection\Objects;

class FactoryWithoutParameter
{
    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
