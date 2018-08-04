<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class Configurator
{

    public function config(): ConfigCollection
    {
        return new ConfigCollection();
    }

    public function bind(string $abstract, string $concrete): Config
    {
        return new BindConfig($abstract, $concrete);
    }
}
