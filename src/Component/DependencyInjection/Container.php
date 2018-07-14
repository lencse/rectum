<?php

namespace Lencse\Rectum\Component\DependencyInjection;

interface Container
{

    public function make(string $class): object;

    public function bind(string $abstract, string $concrete): void;

    public function factory(string $class, string $factoryClass): void;

    public function setup(string $class, array $params = []): void;

    public function bindInstance(string $class, object $instance): void;
}
