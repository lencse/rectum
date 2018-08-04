<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class Configurator
{

    public function config(): ConfigCollection
    {
        return new ConfigCollection();
    }

    public function bind(string $abstract, string $concrete): BindConfig
    {
        return new BindConfig($abstract, $concrete);
    }

    public function setup(string $class): SetupConfig
    {
        return new SetupConfig($class);
    }

    public function instance(string $className, $instance): InstanceConfig
    {
        return new InstanceConfig($className, $instance);
    }
}
