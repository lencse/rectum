<?php

namespace Lencse\Rectum\Component\DependencyInjection;

interface Container
{

    public function make(string $class): object;
}
