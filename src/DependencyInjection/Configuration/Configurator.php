<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class Configurator
{

    public static function config(): Setup
    {
        return new Setup();
    }

    public static function bind(string $abstract, string $concrete): BindConfig
    {
        return new BindConfig($abstract, $concrete);
    }

    public static function setup(string $class): SetupConfig
    {
        return new SetupConfig($class);
    }

    public static function instance(string $className, $instance): InstanceConfig
    {
        return new InstanceConfig($className, $instance);
    }
}
