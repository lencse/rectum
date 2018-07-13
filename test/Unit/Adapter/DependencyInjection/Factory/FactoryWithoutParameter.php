<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class FactoryWithoutParameter
{

    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
