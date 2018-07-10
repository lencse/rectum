<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class FactoryWithParam
{

    public function __invoke(int $value): MadeByFactory
    {
        return new MadeByFactory($value);
    }
}
