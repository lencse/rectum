<?php

namespace Test\Objects;

class FactoryWithoutParameter
{

    public function __invoke(): ConstructorParameter
    {
        return new ConstructorParameter(1);
    }
}
