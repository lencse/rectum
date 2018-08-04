<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

interface ContainerBuilder
{
    public function bind(BindConfig $config): void;

    public function factory(FactoryConfig $config): void;

    public function setup(SetupConfig $config): void;

    public function instance(InstanceConfig $config): void;
}
