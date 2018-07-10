<?php

namespace Test\Unit\Adapter\DependencyInjection\Factory;

class Factory
{

    public function __invoke(): Creatable
    {
        return new Creatable(1);
    }
}
