<?php

namespace Lencse\Rectum\DependencyInjection;

interface Container
{

    public function make(string $class): object;

    public function bind(string $abstract, string $concrete): void;

    public function factory(string $class, string $factoryClass): void;
}
