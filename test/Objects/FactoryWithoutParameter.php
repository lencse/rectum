<?php

namespace Test\Unit\Framework\DependencyInjection\Factory;

class FactoryWithoutParameter
{

    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
