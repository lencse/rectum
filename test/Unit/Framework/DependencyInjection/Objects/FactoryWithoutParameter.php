<?php

namespace Test\Unit\Framework\DependencyInjection\Objects;

class FactoryWithoutParameter
{

    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
