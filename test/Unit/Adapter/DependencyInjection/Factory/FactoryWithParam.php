<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class FactoryWithParam
{

    public function __invoke(int $value): Creatable
    {
        return new Creatable($value);
    }
}
