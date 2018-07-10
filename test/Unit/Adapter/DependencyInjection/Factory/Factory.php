<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class Factory
{

    public function __invoke(): MadeByFactory
    {
        return new MadeByFactory(1);
    }
}
